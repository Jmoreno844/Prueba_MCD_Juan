<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\TipoProteccionDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\TipoProteccionService;

class TipoProteccionController extends Controller
{
    protected $tipoProteccionService;
    protected $fields = ['Descripcion'];

    public function __construct(TipoProteccionService $tipoProteccionService)
    {
        $this->tipoProteccionService = $tipoProteccionService;
    }

    /**
 * @OA\Get(
 *     path="/api/tipoProteccion",
 *     tags={"TipoProteccion"},
 *     summary="Obtener lista de tipos de protección",
 *     description="Retorna una lista de tipos de protección",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="Descripcion", type="string", description="Descripción del tipo de protección")
 *             )
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->tipoProteccionService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/tipoProteccion",
 *     tags={"TipoProteccion"},
 *     summary="Crear un nuevo tipo de protección",
 *     description="Crea un nuevo tipo de protección con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información del tipo de protección para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Descripcion", type="string", description="Descripción del tipo de protección")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tipo de protección creado correctamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new TipoProteccionDTO($request, $this->fields);
            $this->tipoProteccionService->store($dto);

            return response()->json(['message' => 'TipoProteccion creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/tipoProteccion/{id}",
 *     tags={"TipoProteccion"},
 *     summary="Obtener un tipo de protección",
 *     description="Retorna un tipo de protección por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del tipo de protección",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="Descripcion", type="string", description="Descripción del tipo de protección")
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function show($id)
    {
        $item = $this->tipoProteccionService->show($id);
        return response()->json($item);
    }

    /**
 * @OA\Put(
 *     path="/api/tipoProteccion/{id}",
 *     tags={"TipoProteccion"},
 *     summary="Actualizar un tipo de protección",
 *     description="Actualiza un tipo de protección con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del tipo de protección a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información del tipo de protección para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Descripcion", type="string", description="Descripción del tipo de protección")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tipo de protección actualizado correctamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new TipoProteccionDTO($request, $this->fields);
            $this->tipoProteccionService->update($id, $dto);

            return response()->json(['message' => 'TipoProteccion actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

/**
 * @OA\Delete(
 *     path="/api/tipoProteccion/{id}",
 *     tags={"TipoProteccion"},
 *     summary="Eliminar un tipo de protección",
 *     description="Elimina un tipo de protección por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del tipo de protección a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tipo de protección eliminado correctamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function destroy($id)
    {
        try {
            $this->tipoProteccionService->destroy($id);

            return response()->json(['message' => 'TipoProteccion eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
