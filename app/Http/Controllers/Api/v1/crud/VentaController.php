<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\VentaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\VentaService;

class VentaController extends Controller
{
    protected $ventaService;
    protected $fields = ['Fecha',"IdEmpleadoFK", 'IdClienteFK', 'IdFormaPagoFK'];

    public function __construct(VentaService $ventaService)
    {
        $this->ventaService = $ventaService;
    }

    /**
 * @OA\Get(
 *     path="/api/venta",
 *     tags={"Venta"},
 *     summary="Obtener lista de ventas",
 *     description="Retorna una lista de ventas",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="Fecha", type="string", format="date", description="Fecha de la venta"),
 *                 @OA\Property(property="IdEmpleadoFK", type="integer", description="ID del empleado"),
 *                 @OA\Property(property="IdClienteFK", type="integer", description="ID del cliente"),
 *                 @OA\Property(property="IdFormaPagoFK", type="integer", description="ID de la forma de pago")
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
        $items = $this->ventaService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/venta",
 *     tags={"Venta"},
 *     summary="Crear una nueva venta",
 *     description="Crea una nueva venta con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información de la venta para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Fecha", type="string", format="date", description="Fecha de la venta"),
 *             @OA\Property(property="IdEmpleadoFK", type="integer", description="ID del empleado"),
 *             @OA\Property(property="IdClienteFK", type="integer", description="ID del cliente"),
 *             @OA\Property(property="IdFormaPagoFK", type="integer", description="ID de la forma de pago")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Venta creada correctamente",
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
                    'Fecha' => 'required|date',
                    'IdClienteFK' => 'required|integer|exists:cliente,id',
                    'IdFormaPagoFK' => 'required|integer|exists:forma_pago,id',
                    'IdEmpleadoFK' => 'required|integer|exists:empleado,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new VentaDTO($request, $this->fields);
            $this->ventaService->store($dto);

            return response()->json(['message' => 'Venta creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

/**
 * @OA\Get(
 *     path="/api/venta/{id}",
 *     tags={"Venta"},
 *     summary="Obtener una venta",
 *     description="Retorna una venta por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la venta",
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
 *             @OA\Property(property="Fecha", type="string", format="date", description="Fecha de la venta"),
 *             @OA\Property(property="IdEmpleadoFK", type="integer", description="ID del empleado"),
 *             @OA\Property(property="IdClienteFK", type="integer", description="ID del cliente"),
 *             @OA\Property(property="IdFormaPagoFK", type="integer", description="ID de la forma de pago")
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
        $item = $this->ventaService->show($id);
        return response()->json($item);
    }

/**
 * @OA\Put(
 *     path="/api/venta/{id}",
 *     tags={"Venta"},
 *     summary="Actualizar una venta",
 *     description="Actualiza una venta con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la venta a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información de la venta para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Fecha", type="string", format="date", description="Fecha de la venta"),
 *             @OA\Property(property="IdEmpleadoFK", type="integer", description="ID del empleado"),
 *             @OA\Property(property="IdClienteFK", type="integer", description="ID del cliente"),
 *             @OA\Property(property="IdFormaPagoFK", type="integer", description="ID de la forma de pago")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venta actualizada correctamente",
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
            'Fecha' => 'required|date',
            'IdClienteFK' => 'required|integer|exists:cliente,id',
            'IdFormaPagoFK' => 'required|integer|exists:forma_pago,id',
            'IdEmpleadoFK' => 'required|integer|exists:empleado,id'
]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new VentaDTO($request, $this->fields);
            $this->ventaService->update($id, $dto);

            return response()->json(['message' => 'Venta actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/venta/{id}",
 *     tags={"Venta"},
 *     summary="Eliminar una venta",
 *     description="Elimina una venta por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la venta a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Venta eliminada correctamente",
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
            $this->ventaService->destroy($id);

            return response()->json(['message' => 'Venta eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
