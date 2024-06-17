<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\InventarioDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InventarioService;

class InventarioController extends Controller
{
    protected $inventarioService;
    protected $fields = ['CodInv', 'IdPrendaFk', 'IdTallaFK', 'IdColorFK', 'Cantidad'];

    public function __construct(InventarioService $inventarioService)
    {
        $this->inventarioService = $inventarioService;
    }

/**
 * @OA\Get(
 *     path="/api/inventario",
 *     tags={"Inventario"},
 *     summary="Obtener lista de inventario",
 *     description="Retorna una lista del inventario",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="CodInv", type="integer", description="Código de inventario"),
 *                 @OA\Property(property="IdPrendaFk", type="integer", description="ID de prenda"),
 *                 @OA\Property(property="IdTallaFK", type="integer", description="ID de talla"),
 *                 @OA\Property(property="IdColorFK", type="integer", description="ID de color"),
 *                 @OA\Property(property="Cantidad", type="integer", description="Cantidad")
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
        $items = $this->inventarioService->index($perPage);
        return response()->json($items);
    }

/**
 * @OA\Post(
 *     path="/api/inventario",
 *     tags={"Inventario"},
 *     summary="Crear un nuevo item de inventario",
 *     description="Crea un nuevo item de inventario con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información de inventario para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="CodInv", type="integer", description="Código de inventario"),
 *             @OA\Property(property="IdPrendaFk", type="integer", description="ID de prenda"),
 *             @OA\Property(property="IdTallaFK", type="integer", description="ID de talla"),
 *             @OA\Property(property="IdColorFK", type="integer", description="ID de color"),
 *             @OA\Property(property="Cantidad", type="integer", description="Cantidad")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Item de inventario creado exitosamente",
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
            'CodInv' => 'required|string|max:255',
                    'IdPrendaFk' => 'required|integer|exists:prenda,id',
                    'IdTallaFK' => 'required|integer|exists:talla,id',
                    'IdColorFK' => 'required|integer|exists:color,id',
                    'Cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InventarioDTO($request, $this->fields);
            $this->inventarioService->store($dto);

            return response()->json(['message' => 'Inventario creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


/**
 * @OA\Get(
 *     path="/api/inventario/{CodInv}",
 *     tags={"Inventario"},
 *     summary="Obtener un item de inventario",
 *     description="Retorna un item de inventario por su CodInv",
 *     @OA\Parameter(
 *         name="CodInv",
 *         in="path",
 *         description="Código de inventario",
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
 *             @OA\Property(property="CodInv", type="integer", description="Código de inventario"),
 *             @OA\Property(property="IdPrendaFk", type="integer", description="ID de prenda"),
 *             @OA\Property(property="IdTallaFK", type="integer", description="ID de talla"),
 *             @OA\Property(property="IdColorFK", type="integer", description="ID de color"),
 *             @OA\Property(property="Cantidad", type="integer", description="Cantidad")
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
        $item = $this->inventarioService->show($id);
        return response()->json($item);
    }

/**
 * @OA\Put(
 *     path="/api/inventario/{id}",
 *     tags={"Inventario"},
 *     summary="Actualizar un item de inventario",
 *     description="Actualiza un item de inventario con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del item de inventario a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información de inventario para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="CodInv", type="string", description="Código de inventario", maxLength=255),
 *             @OA\Property(property="IdPrendaFk", type="integer", description="ID de prenda"),
 *             @OA\Property(property="IdTallaFK", type="integer", description="ID de talla"),
 *             @OA\Property(property="IdColorFK", type="integer", description="ID de color"),
 *             @OA\Property(property="Cantidad", type="integer", description="Cantidad")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Item de inventario actualizado exitosamente",
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
            'CodInv' => 'required|string|max:255',
                    'IdPrendaFk' => 'required|integer|exists:prenda,id',
                    'IdTallaFK' => 'required|integer|exists:talla,id',
                    'IdColorFK' => 'required|integer|exists:color,id',
                    'Cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InventarioDTO($request, $this->fields);
            $this->inventarioService->update($id, $dto);

            return response()->json(['message' => 'Inventario actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/inventario/{CodInv}",
 *     tags={"Inventario"},
 *     summary="Eliminar un item de inventario",
 *     description="Elimina un item de inventario por su CodInv",
 *     @OA\Parameter(
 *         name="CodInv",
 *         in="path",
 *         description="Código de inventario",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Item de inventario eliminado exitosamente",
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
            $this->inventarioService->destroy($id);

            return response()->json(['message' => 'Inventario eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
