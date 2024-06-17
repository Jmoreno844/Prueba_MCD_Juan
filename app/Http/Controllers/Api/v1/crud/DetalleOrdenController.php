<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\DetalleOrdenDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\DetalleOrdenService;

class DetalleOrdenController extends Controller
{
    protected $detalleOrdenService;
    protected $fields = ['IdOrdenFk', 'IdPrendaFk', 'IdColorFK', 'IdTallaFK', 'PrendaId', 'cantidad_producir', 'cantidad_producida', 'IdEstadoFk'];

    public function __construct(DetalleOrdenService $detalleOrdenService)
    {
        $this->detalleOrdenService = $detalleOrdenService;
    }

    /**
     * @OA\Post(
     *     path="/api/detalleorden",
     *     tags={"DetalleOrden"},
     *     summary="Crear un nuevo DetalleOrden",
     *     description="Crea un nuevo DetalleOrden y devuelve los datos",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="DetalleOrden para almacenar",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="IdOrdenFk", type="integer"),
     *             @OA\Property(property="IdPrendaFk", type="integer"),
     *             @OA\Property(property="IdColorFK", type="integer"),
     *             @OA\Property(property="IdTallaFK", type="integer"),
     *             @OA\Property(property="PrendaId", type="integer"),
     *             @OA\Property(property="cantidad_producir", type="integer"),
     *             @OA\Property(property="cantidad_producida", type="integer"),
     *             @OA\Property(property="IdEstadoFk", type="integer"),
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdOrdenFk' => 'required|integer',
            'IdPrendaFk' => 'required|integer',
            'IdColorFK' => 'required|integer',
            'IdTallaFK' => 'required|integer',
            'PrendaId' => 'required|integer',
            'cantidad_producir' => 'required|integer',
            'cantidad_producida' => 'required|integer',
            'IdEstadoFk' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DetalleOrdenDTO($request, $this->fields);
            $this->detalleOrdenService->store($dto);

            return response()->json(['message' => 'DetalleOrden creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/detalleorden/{id}",
     *     tags={"DetalleOrden"},
     *     summary="Actualizar un DetalleOrden existente",
     *     description="Actualiza un DetalleOrden existente y devuelve los datos actualizados",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del DetalleOrden que se va a actualizar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validación fallida"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="DetalleOrden para actualizar",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="IdOrdenFk", type="integer"),
     *             @OA\Property(property="IdPrendaFk", type="integer"),
     *             @OA\Property(property="IdColorFK", type="integer"),
     *             @OA\Property(property="IdTallaFK", type="integer"),
     *             @OA\Property(property="PrendaId", type="integer"),
     *             @OA\Property(property="cantidad_producir", type="integer"),
     *             @OA\Property(property="cantidad_producida", type="integer"),
     *             @OA\Property(property="IdEstadoFk", type="integer"),
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'IdOrdenFk' => 'required|integer',
            'IdPrendaFk' => 'required|integer',
            'IdColorFK' => 'required|integer',
            'IdTallaFK' => 'required|integer',
            'PrendaId' => 'required|integer',
            'cantidad_producir' => 'required|integer',
            'cantidad_producida' => 'required|integer',
            'IdEstadoFk' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DetalleOrdenDTO($request, $this->fields);
            $this->detalleOrdenService->update($id, $dto);

            return response()->json(['message' => 'DetalleOrden actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/detalleorden/{id}",
     *     tags={"DetalleOrden"},
     *     summary="Obtener DetalleOrden por ID",
     *     description="Obtiene un DetalleOrden por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del DetalleOrden que se va a obtener",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     )
     * )
     */
    public function show($id)
    {
        $item = $this->detalleOrdenService->show($id);
        return response()->json($item);
    }

    /**
     * @OA\Get(
     *     path="/api/detalleorden",
     *     tags={"DetalleOrden"},
     *     summary="Obtener lista de DetalleOrden",
     *     description="Obtiene una lista de todos los DetalleOrden",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->detalleOrdenService->index($perPage);
        return response()->json($items);
    }

    /**
     * @OA\Delete(
     *     path="/api/detalleorden/{id}",
     *     tags={"DetalleOrden"},
     *     summary="Eliminar un DetalleOrden existente",
     *     description="Elimina un DetalleOrden por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del DetalleOrden que se va a eliminar",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->detalleOrdenService->destroy($id);

            return response()->json(['message' => 'DetalleOrden eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
