<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\GeneroDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\GeneroService;

class GeneroController extends Controller
{
    protected $generoService;
    protected $fields = ['descripcion'];

    public function __construct(GeneroService $generoService)
    {
        $this->generoService = $generoService;
    }

     /**
     * @OA\Get(
     *     path="/api/genero",
     *     tags={"Genero"},
     *     summary="Obtener todos los géneros",
     *     description="Retorna una lista de géneros",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->generoService->index($perPage);
        return response()->json($items);
    }

    /**
     * @OA\Post(
     *     path="/api/genero",
     *     tags={"Genero"},
     *     summary="Crear un nuevo género",
     *     description="Crea un nuevo género y lo retorna",
     *     @OA\RequestBody(
     *         description="Género a crear",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="descripcion",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Género creado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new GeneroDTO($request, $this->fields);
            $this->generoService->store($dto);

            return response()->json(['message' => 'Genero creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/genero/{id}",
     *     tags={"Genero"},
     *     summary="Obtener un género por ID",
     *     description="Retorna un género por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del género a obtener",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     )
     * )
     */
    public function show($id)
    {
        $item = $this->generoService->show($id);
        return response()->json($item);
    }


    /**
     * @OA\Put(
     *     path="/api/genero/{id}",
     *     tags={"Genero"},
     *     summary="Actualizar un género por ID",
     *     description="Actualiza un género por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del género a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Género a actualizar",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="descripcion",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Género actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new GeneroDTO($request, $this->fields);
            $this->generoService->update($id, $dto);

            return response()->json(['message' => 'Genero actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

     /**
     * @OA\Delete(
     *     path="/api/genero/{id}",
     *     tags={"Genero"},
     *     summary="Eliminar un género por ID",
     *     description="Elimina un género por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del género a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Género eliminado correctamente"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->generoService->destroy($id);

            return response()->json(['message' => 'Genero eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
