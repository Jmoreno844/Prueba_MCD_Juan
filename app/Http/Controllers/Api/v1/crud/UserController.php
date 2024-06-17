<?php

namespace App\Http\Controllers\Api\v1\crud;

use Hash, Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\Controller;
use Auth;


class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Users"},
     *     summary="Registra un nuevo usuario.",
     *     description="Registra un nuevo usuario dado un email,contraseña y nombre.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="name", type="string", example="John Doe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registration successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="name", type="string", example="John Doe")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            "email" => "email|max:255|string|required",
            "password" => "string|required",
            "name" => "string|required|max:255"
        ]);

        $user = User::create([
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"])
        ]);

        return response()->json(["message"=>"Creado con exito","email"=>$data["email"], 200]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Users"},
     *     summary="Inicia sesion al usuario",
     *     description="Autentica el usuario dado el email y la contraseña.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logeado existosamente.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Credenciales invalidas.")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'Logeado existosamente.']);
        }

        return response()->json(['message' => 'Credenciales invalidas.'], 401);
    }

    /**
     * @OA\Post(
     *     path="/api/generate-jwt",
     *     tags={"Users"},
     *     summary="Generate un token JWT",
     *     description="Generate un token JWT",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="jmoreno844@gmail.com"),
     *             @OA\Property(property="password", type="string", example="123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token generated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="Bearer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Credenciales invalidas.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="JWT permission denied",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El usuario no tiene permiso JWT")
     *         )
     *     )
     * )
     */
    public function generateJWT(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Credenciales invalidas.'], 401);
        }

        $user = Auth::user();

        if (!$user->jwt_permission) {
            return response()->json(['message' => "El usuario no tiene permiso JWT"], 403);
        }

        $token = auth('api')->login($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/signout",
     *     tags={"Users"},
     *     summary="Cierra la sesion del usuario",
     *     description="Cierre de sesion del usuario",
     *     @OA\Response(
     *         response=200,
     *         description="Sign out successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Signed out successfully")
     *         )
     *     )
     * )
     */
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return response()->json(['message' => 'Signed out successfully']);
    }
}
