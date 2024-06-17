<?php

namespace App\Http\Controllers\Api\v1\crud;
use Hash, Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\v1\Controller;
use Auth;
class UserController extends Controller
{
    public function register(Request $request){


        $data = $request->validate([
            "email"=> "email|max:255|string|required",
            "password"=> "string|required",
            "name" => "string|required|max:255"]);

        $user = User::create(["name"=>$data["name"],
        "email"=>$data["email"],
        "password"=>Hash::make($data["password"])
    ]);
        return  response()->json([$data, 200]);;
    }




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


public function generateJWT(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Verificar si las credenciales son válidas
    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Credenciales invalidas.'], 401);
    }

    // Obtener el usuario autenticado
    $user = Auth::user();

    // Verificar si el usuario tiene permiso para usar JWT
    if (!$user->jwt_permission) {
        return response()->json(['message' => "El usuario no tiene permiso JWT"], 403);
    }

    // Generar el token JWT
    $token = auth('api')->login($user);

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
    ]);
}

        public function check(Request $request)
        {
        // Use the 'auth:api' middleware to authenticate the user based on the JWT
         $user = Auth::guard('api')->user();

            if ($user) {
            // If the user is authenticated
            return response()->json(['email' => $user->email, 'message' => 'Token is valid']);
         } else {
               // If the user is not authenticated
                return response()->json(['message' => 'Token is invalid'], 401);
            }
        }

        public function signOut() {
            Session::flush();
            Auth::logout();
            return Redirect('login');
}
}
