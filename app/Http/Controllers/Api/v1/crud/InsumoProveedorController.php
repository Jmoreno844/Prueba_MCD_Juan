<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\InsumoProveedorDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InsumoProveedorService;

class InsumoProveedorController extends Controller
{
    protected $insumoProveedorService;
    protected $fields = ['IdInsumoFK', 'IdProveedorFK'];

    public function __construct(InsumoProveedorService $insumoProveedorService)
    {
        $this->insumoProveedorService = $insumoProveedorService;
    }

    /**
 * @OA\Get(
 *     path="/api/insumoProveedor",
 *     tags={"InsumoProveedor"},
 *     summary="Obtener lista de insumos de proveedores",
 *     description="Retorna una lista de insumos de proveedores",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="idInsumoFK", type="integer", description="ID del insumo"),
 *                 @OA\Property(property="idProveedorFK", type="integer", description="ID del proveedor")
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
        $items = $this->insumoProveedorService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/insumoProveedor/{idInsumoFK}/{idProveedorFK}",
 *     tags={"InsumoProveedor"},
 *     summary="Crear un nuevo insumo de proveedor",
 *     description="Crea un nuevo insumo de proveedor con los datos enviados",
 *     @OA\Parameter(
 *         name="idInsumoFK",
 *         in="path",
 *         description="ID del insumo",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="idProveedorFK",
 *         in="path",
 *         description="ID del proveedor",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Insumo de proveedor creado exitosamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function store($idInsumoFK, $idProveedorFK)
    {
        $data = [
            'idInsumoFK' => $idInsumoFK,
            'idProveedorFK' => $idProveedorFK
        ];

        $rules = [
            'idInsumoFK' => 'required|integer|exists:insumo,id',
            'idProveedorFK' => 'required|integer|exists:proveedor,id'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $this->insumoProveedorService->store($idInsumoFK, $idProveedorFK);

            return response()->json(['message' => 'InsumoProveedor creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/insumoProveedor/{idInsumoFK}/{idProveedorFK}",
 *     tags={"InsumoProveedor"},
 *     summary="Obtener un insumo de proveedor",
 *     description="Retorna un insumo de proveedor por su idInsumoFK y idProveedorFK",
 *     @OA\Parameter(
 *         name="idInsumoFK",
 *         in="path",
 *         description="ID del insumo",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="idProveedorFK",
 *         in="path",
 *         description="ID del proveedor",
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
 *             @OA\Property(property="idInsumoFK", type="integer", description="ID del insumo"),
 *             @OA\Property(property="idProveedorFK", type="integer", description="ID del proveedor")
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function show($idInsumoFK, $idProveedorFK )
    {
        $item = $this->insumoProveedorService->show($idInsumoFK,$idProveedorFK);
        if(!$item){
            return response()->json(['message' => 'InsumoProveedor no encontrado.'], 404);
        }
        return response()->json(["message" => "InsumoProveedor existe en (Insumo,Proovedor) = (".$idInsumoFK.",".$idProveedorFK.")."],200);

    }

/**
 * @OA\Delete(
 *     path="/api/insumoProveedor/{idInsumoFK}/{idProveedorFK}",
 *     tags={"InsumoProveedor"},
 *     summary="Eliminar un insumo de proveedor",
 *     description="Elimina un insumo de proveedor por su idInsumoFK y idProveedorFK",
 *     @OA\Parameter(
 *         name="idInsumoFK",
 *         in="path",
 *         description="ID del insumo",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="idProveedorFK",
 *         in="path",
 *         description="ID del proveedor",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Insumo de proveedor eliminado exitosamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function destroy($idInsumoFK, $idProveedorFK)
    {
        try {
            $this->insumoProveedorService->destroy($idInsumoFK, $idProveedorFK);

            return response()->json(['message' => 'InsumoProveedor eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
