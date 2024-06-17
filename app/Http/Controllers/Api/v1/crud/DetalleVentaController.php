<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\DetalleVentaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\DetalleVentaService;

class DetalleVentaController extends Controller
{
    protected $detalleventaService;
    protected $fields = ['IdVentaFk', 'IdInventarioFK', 'cantidad'];

    public function __construct(DetalleVentaService $detalleventaService)
    {
        $this->detalleventaService = $detalleventaService;
    }

/**
     * @OA\Get(
     *     path="/api/detalleVenta",
     *     tags={"DetalleVenta"},
     *     summary="Listar todos los detalles de venta",
     *     description="Obtiene una lista de todos los detalles de venta",
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->detalleventaService->index($perPage);
        return response()->json($items);
    }


    /**
     * @OA\Post(
     *     path="/api/detalleVenta",
     *     tags={"DetalleVenta"},
     *     summary="Crear un nuevo DetalleVenta",
     *     description="Crea un nuevo DetalleVenta y devuelve los datos",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="DetalleVenta para almacenar",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="IdVentaFK", type="integer"),
     *             @OA\Property(property="IdInventarioFK", type="integer"),
     *             @OA\Property(property="Cantidad", type="integer"),
     *
     *         )
     *     )
     * )
     */

     public function store(Request $request)
     {
         $validator = Validator::make($request->all(), [
             'IdVentaFk' => 'required|integer',
                     'IdInventarioFK' => 'required|integer',
                     'cantidad' => 'required|integer'
         ]);

         if ($validator->fails()) {
             return response()->json(['message' => $validator->errors()], 422);
         }

         try {
             $dto = new DetalleVentaDTO($request, $this->fields);
             $this->detalleventaService->store($dto);

             return response()->json(['message' => 'DetalleVenta creado correctamente.']);
         } catch (\Exception $e) {
             return response()->json(['message' => $e->getMessage()], 500);
         }
     }

    /**
     * @OA\Put(
     *     path="/api/detalleVenta/{id}",
     *     tags={"DetalleVenta"},
     *     summary="Actualizar un DetalleVenta existente",
     *     description="Actualiza un DetalleVenta existente y devuelve los datos actualizados",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del DetalleVenta que se va a actualizar",
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
     *         description="DetalleVenta para actualizar",
     *         @OA\JsonContent(
     *             type="object",
     *           @OA\Property(property="IdVentaFK", type="integer"),
     *             @OA\Property(property="IdInventarioFK", type="integer"),
     *             @OA\Property(property="Cantidad", type="integer"),
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'IdVentaFk' => 'required|integer',
                    'IdInventarioFK' => 'required|integer',
                    'cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DetalleVentaDTO($request, $this->fields);
            $this->detalleventaService->update($id, $dto);

            return response()->json(['message' => 'DetalleVenta actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/detalleVenta/{id}",
     *     tags={"DetalleVenta"},
     *     summary="Obtener DetalleVenta por ID",
     *     description="Obtiene un DetalleVenta por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del DetalleVenta que se va a obtener",
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
        $item = $this->detalleventaService->show($id);
        return response()->json($item);
    }


    /**
     * @OA\Delete(
     *     path="/api/detalleVenta/{id}",
     *     tags={"DetalleVenta"},
     *     summary="Eliminar un DetalleVenta existente",
     *     description="Elimina un DetalleVenta por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del DetalleVenta que se va a eliminar",
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
            $this->detalleventaService->destroy($id);

            return response()->json(['message' => 'DetalleVenta eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
