<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\InsumoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InsumoService;

class InsumoController extends Controller
{
    protected $insumoService;
    protected $fields = ['nombre', 'valor_unit', 'stock_min', 'stock_max'];

    public function __construct(InsumoService $insumoService)
    {
        $this->insumoService = $insumoService;
    }

      /**
     * @OA\Get(
     *     path="/api/insumo",
     *     tags={"Insumo"},
     *     summary="Obtener todos los insumos",
     *     description="Retorna una lista de insumos",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->insumoService->index($perPage);
        return response()->json($items);
    }
 /**
     * @OA\Post(
     *     path="/api/insumo",
     *     tags={"Insumo"},
     *     summary="Crear un nuevo insumo",
     *     description="Crea un nuevo insumo y lo retorna",
     *     @OA\RequestBody(
     *         description="Insumo a crear",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nombre",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="valor_unit",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="stock_min",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="stock_max",
     *                     type="number"
     *                 )
     *             )
     *         )
      *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Insumo creado correctamente"
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
            'nombre' => 'required|max:50',
                    'valor_unit' => 'required|numeric',
                    'stock_min' => 'required|numeric',
                    'stock_max' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InsumoDTO($request, $this->fields);
            $this->insumoService->store($dto);

            return response()->json(['message' => 'Insumo creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/insumo/{id}",
     *     tags={"Insumo"},
     *     summary="Obtener un insumo por ID",
     *     description="Retorna un insumo por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del insumo a obtener",
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
        $item = $this->insumoService->show($id);
        return response()->json($item);
    }
      /**
     * @OA\Put(
     *     path="/api/insumo/{id}",
     *     tags={"Insumo"},
     *     summary="Actualizar un insumo por ID",
     *     description="Actualiza un insumo por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del insumo a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Insumo a actualizar",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nombre",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="valor_unit",
     *                     type="number"
     *                 ),
      *                 @OA\Property(
     *                     property="stock_min",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="stock_max",
     *                     type="number"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Insumo actualizado correctamente"
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
            'nombre' => 'required|max:50',
                    'valor_unit' => 'required|numeric',
                    'stock_min' => 'required|numeric',
                    'stock_max' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InsumoDTO($request, $this->fields);
            $this->insumoService->update($id, $dto);

            return response()->json(['message' => 'Insumo actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


     /**
     * @OA\Delete(
     *     path="/api/insumo/{id}",
     *     tags={"Insumo"},
     *     summary="Eliminar un insumo por ID",
     *     description="Elimina un insumo por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del insumo a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Insumo eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->insumoService->destroy($id);

            return response()->json(['message' => 'Insumo eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
