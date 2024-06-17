<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InsumoPrendasService;

class InsumoPrendasController extends Controller
{
    protected $insumoPrendasService;
    protected $fields = ['IdInsumoFk', 'IdPrendaFk', 'Cantidad'];

    public function __construct(InsumoPrendasService $insumoPrendasService)
    {
        $this->insumoPrendasService = $insumoPrendasService;
    }

    /**
 * @OA\Get(
 *     path="/api/insumoPrendas",
 *     tags={"InsumoPrendas"},
 *     summary="Obtener lista de insumos de prendas",
 *     description="Retorna una lista de insumos de prendas",
 *
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->insumoPrendasService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/insumoPrendas/{idInsumoFK}/{idPrendaFK}",
 *     tags={"InsumoPrendas"},
 *     summary="Crear un nuevo insumo de prenda",
 *     description="Crea un nuevo insumo de prenda con los datos enviados",
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
 *         name="idPrendaFK",
 *         in="path",
 *         description="ID de la prenda",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Insumo de prenda creado exitosamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function store($idInsumoFK, $idPrendaFK,Request $request)
    {
        $data = [
            'IdInsumoFk' => $idInsumoFK,
            'IdPrendaFk' => $idPrendaFK,
            'Cantidad' => $request->input('Cantidad')
        ];

        $rules = [
            'IdInsumoFk' => 'required|integer|exists:insumo,id',
            'IdPrendaFk' => 'required|integer|exists:prenda,id',
            'Cantidad' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);

        $cantidad = $validator->getData()['Cantidad'];
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $this->insumoPrendasService->store($idInsumoFK, $idPrendaFK, $cantidad);

            return response()->json(['message' => 'InsumoPrendas creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/insumoPrendas/{idInsumoFK}/{idPrendaFK}",
 *     tags={"InsumoPrendas"},
 *     summary="Obtener un insumo de prenda",
 *     description="Retorna un insumo de prenda por su idInsumoFK y idPrendaFK",
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
 *         name="idPrendaFK",
 *         in="path",
 *         description="ID de la prenda",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function show($idInsumoFK, $idPrendaFK)
    {
        $item = $this->insumoPrendasService->show($idInsumoFK, $idPrendaFK);
        return response()->json($item);
    }

    /**
 * @OA\Put(
 *     path="/api/insumoPrendas/{idInsumoFK}/{idPrendaFK}",
 *     tags={"InsumoPrendas"},
 *     summary="Actualizar un insumo de prenda",
 *     description="Actualiza un insumo de prenda por su idInsumoFK y idPrendaFK",
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
 *         name="idPrendaFK",
 *         in="path",
 *         description="ID de la prenda",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Insumo de prenda actualizado exitosamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function update($idInsumoFK,$idPrendaFK,Request $request)
    {
        $data = [
            'IdInsumoFk' => $idInsumoFK,
            'IdPrendaFk' => $idPrendaFK,
            'Cantidad' => $request->input('Cantidad')
        ];

        $rules = [
            'IdInsumoFk' => 'required|integer|exists:insumo,id',
            'IdPrendaFk' => 'required|integer|exists:prenda,id',
            'Cantidad' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);

        $cantidad = $validator->getData()['Cantidad'];

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $this->insumoPrendasService->update($idInsumoFK, $idPrendaFK, $cantidad);

            return response()->json(['message' => 'InsumoPrendas actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

/**
 * @OA\Delete(
 *     path="/api/insumoPrendas/{idInsumoFK}/{idPrendaFK}",
 *     tags={"InsumoPrendas"},
 *     summary="Eliminar un insumo de prenda",
 *     description="Elimina un insumo de prenda por su idInsumoFK y idPrendaFK",
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
 *         name="idPrendaFK",
 *         in="path",
 *         description="ID de la prenda",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Insumo de prenda eliminado exitosamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function destroy($idInsumoFK, $idPrendaFK)
    {
        try {
            $this->insumoPrendasService->destroy($idInsumoFK, $idPrendaFK);

            return response()->json(['message' => 'InsumoPrendas eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
