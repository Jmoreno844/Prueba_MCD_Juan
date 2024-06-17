<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\OrdenDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\OrdenService;

class OrdenController extends Controller
{
    protected $ordenService;
    protected $fields = ['fecha', 'IdEmpleadoFK', 'IdClienteFK', 'IdEstadoFK'];

    public function __construct(OrdenService $ordenService)
    {
        $this->ordenService = $ordenService;
    }

    /**
 * @OA\Get(
 *     path="/api/orden",
 *     tags={"Orden"},
 *     summary="Obtener lista de ordenes",
 *     description="Retorna una lista de ordenes",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="fecha", type="string", format="date", description="Fecha de la orden"),
 *                 @OA\Property(property="IdEmpleadoFK", type="integer", description="ID del empleado"),
 *                 @OA\Property(property="IdClienteFK", type="integer", description="ID del cliente"),
 *                 @OA\Property(property="IdEstadoFK", type="integer", description="ID del estado")
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
        $items = $this->ordenService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/orden",
 *     tags={"Orden"},
 *     summary="Crear una nueva orden",
 *     description="Crea una nueva orden con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información de la orden para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="fecha", type="string", format="date", description="Fecha de la orden"),
 *             @OA\Property(property="IdEmpleadoFK", type="integer", description="ID del empleado"),
 *             @OA\Property(property="IdClienteFK", type="integer", description="ID del cliente"),
 *             @OA\Property(property="IdEstadoFK", type="integer", description="ID del estado")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Orden creada correctamente",
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
            'fecha' => 'required|date',
                    'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                    'IdClienteFK' => 'required|integer|exists:cliente,id',
                    'IdEstadoFK' => 'required|integer|exists:estado,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new OrdenDTO($request, $this->fields);
            $this->ordenService->store($dto);

            return response()->json(['message' => 'Orden creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/orden/{id}",
 *     tags={"Orden"},
 *     summary="Obtener una orden",
 *     description="Retorna una orden por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la orden",
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
 *             @OA\Property(property="fecha", type="string", format="date", description="Fecha de la orden"),
 *             @OA\Property(property="IdEmpleadoFK", type="integer", description="ID del empleado"),
 *             @OA\Property(property="IdClienteFK", type="integer", description="ID del cliente"),
 *             @OA\Property(property="IdEstadoFK", type="integer", description="ID del estado")
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
        $item = $this->ordenService->show($id);
        return response()->json($item);
    }

    /**
 * @OA\Put(
 *     path="/api/orden/{id}",
 *     tags={"Orden"},
 *     summary="Actualizar una orden",
 *     description="Actualiza una orden con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la orden a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información de la orden para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="fecha", type="string", format="date", description="Fecha de la orden"),
 *             @OA\Property(property="IdEmpleadoFK", type="integer", description="ID del empleado"),
 *             @OA\Property(property="IdClienteFK", type="integer", description="ID del cliente"),
 *             @OA\Property(property="IdEstadoFK", type="integer", description="ID del estado")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Orden actualizada correctamente",
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
            'fecha' => 'required|date',
                    'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                    'IdClienteFK' => 'required|integer|exists:cliente,id',
                    'IdEstadoFK' => 'required|integer|exists:estado,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new OrdenDTO($request, $this->fields);
            $this->ordenService->update($id, $dto);

            return response()->json(['message' => 'Orden actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/orden/{id}",
 *     tags={"Orden"},
 *     summary="Eliminar una orden",
 *     description="Elimina una orden por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la orden a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Orden eliminada correctamente",
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
            $this->ordenService->destroy($id);

            return response()->json(['message' => 'Orden eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
