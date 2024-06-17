<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\PrendaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\PrendaService;

class PrendaController extends Controller
{
    protected $prendaService;
    protected $fields = ['Nombre', 'ValorUnitCop', 'ValorUnitUsd', 'IdEstadoFK', 'IdTipoProteccionFK', 'IdGeneroFK', 'Codigo'];

    public function __construct(PrendaService $prendaService)
    {
        $this->prendaService = $prendaService;
    }

/**
 * @OA\Get(
 *     path="/api/prenda",
 *     tags={"Prenda"},
 *     summary="Obtener lista de prendas",
 *     description="Retorna una lista de prendas",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="Nombre", type="string", description="Nombre de la prenda"),
 *                 @OA\Property(property="ValorUnitCop", type="number", description="Valor unitario en COP de la prenda"),
 *                 @OA\Property(property="ValorUnitUsd", type="number", description="Valor unitario en USD de la prenda"),
 *                 @OA\Property(property="IdEstadoFK", type="integer", description="ID del estado de la prenda"),
 *                 @OA\Property(property="IdTipoProteccionFK", type="integer", description="ID del tipo de protección de la prenda"),
 *                 @OA\Property(property="IdGeneroFK", type="integer", description="ID del género de la prenda"),
 *                 @OA\Property(property="Codigo", type="string", description="Código de la prenda")
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
        $items = $this->prendaService->index($perPage);
        return response()->json($items);
    }



/**
 * @OA\Post(
 *     path="/api/prenda",
 *     tags={"Prenda"},
 *     summary="Crear una nueva prenda",
 *     description="Crea una nueva prenda con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información de la prenda para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Nombre", type="string", description="Nombre de la prenda"),
 *             @OA\Property(property="ValorUnitCop", type="number", description="Valor unitario en COP de la prenda"),
 *             @OA\Property(property="ValorUnitUsd", type="number", description="Valor unitario en USD de la prenda"),
 *             @OA\Property(property="IdEstadoFK", type="integer", description="ID del estado de la prenda"),
 *             @OA\Property(property="IdTipoProteccionFK", type="integer", description="ID del tipo de protección de la prenda"),
 *             @OA\Property(property="IdGeneroFK", type="integer", description="ID del género de la prenda"),
 *             @OA\Property(property="Codigo", type="string", description="Código de la prenda")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Prenda creada correctamente",
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
            'Nombre' => 'required|string|max:50',
                    'ValorUnitCop' => 'required|numeric',
                    'ValorUnitUsd' => 'required|numeric',
                    'IdEstadoFK' => 'required|integer|exists:estado,id',
                    'IdTipoProteccionFK' => 'required|integer|exists:tipo_proteccion,id',
                    'IdGeneroFK' => 'required|integer|exists:genero,id',
                    'Codigo' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new PrendaDTO($request, $this->fields);
            $this->prendaService->store($dto);

            return response()->json(['message' => 'Prenda creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/prenda/{id}",
 *     tags={"Prenda"},
 *     summary="Obtener una prenda",
 *     description="Retorna una prenda por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la prenda",
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
 *             @OA\Property(property="Nombre", type="string", description="Nombre de la prenda"),
 *             @OA\Property(property="ValorUnitCop", type="number", description="Valor unitario en COP de la prenda"),
 *             @OA\Property(property="ValorUnitUsd", type="number", description="Valor unitario en USD de la prenda"),
 *             @OA\Property(property="IdEstadoFK", type="integer", description="ID del estado de la prenda"),
 *             @OA\Property(property="IdTipoProteccionFK", type="integer", description="ID del tipo de protección de la prenda"),
 *             @OA\Property(property="IdGeneroFK", type="integer", description="ID del género de la prenda"),
 *             @OA\Property(property="Codigo", type="string", description="Código de la prenda")
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
        $item = $this->prendaService->show($id);
        return response()->json($item);
    }

    /**
 * @OA\Put(
 *     path="/api/prenda/{id}",
 *     tags={"Prenda"},
 *     summary="Actualizar una prenda",
 *     description="Actualiza una prenda con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la prenda a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información de la prenda para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Nombre", type="string", description="Nombre de la prenda"),
 *             @OA\Property(property="ValorUnitCop", type="number", description="Valor unitario en COP de la prenda"),
 *             @OA\Property(property="ValorUnitUsd", type="number", description="Valor unitario en USD de la prenda"),
 *             @OA\Property(property="IdEstadoFK", type="integer", description="ID del estado de la prenda"),
 *             @OA\Property(property="IdTipoProteccionFK", type="integer", description="ID del tipo de protección de la prenda"),
 *             @OA\Property(property="IdGeneroFK", type="integer", description="ID del género de la prenda"),
 *             @OA\Property(property="Codigo", type="string", description="Código de la prenda")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Prenda actualizada correctamente",
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
            'Nombre' => 'required|string|max:50',
                    'ValorUnitCop' => 'required|numeric',
                    'ValorUnitUsd' => 'required|numeric',
                    'IdEstadoFK' => 'required|integer|exists:estado,id',
                    'IdTipoProteccionFK' => 'required|integer|exists:tipo_proteccion,id',
                    'IdGeneroFK' => 'required|integer|exists:genero,id',
                    'Codigo' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new PrendaDTO($request, $this->fields);
            $this->prendaService->update($id, $dto);

            return response()->json(['message' => 'Prenda actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/prenda/{id}",
 *     tags={"Prenda"},
 *     summary="Eliminar una prenda",
 *     description="Elimina una prenda por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la prenda a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Prenda eliminada correctamente",
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
            $this->prendaService->destroy($id);

            return response()->json(['message' => 'Prenda eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
