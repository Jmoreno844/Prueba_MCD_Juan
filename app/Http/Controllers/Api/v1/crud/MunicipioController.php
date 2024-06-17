<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\MunicipioDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\MunicipioService;

class MunicipioController extends Controller
{
    protected $municipioService;
    protected $fields = ['nombre', 'idDepartamentoFK'];

    public function __construct(MunicipioService $municipioService)
    {
        $this->municipioService = $municipioService;
    }

    /**
 * @OA\Get(
 *     path="/api/municipio",
 *     tags={"Municipio"},
 *     summary="Obtener lista de municipios",
 *     description="Retorna una lista de municipios",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="nombre", type="string", description="Nombre del municipio"),
 *                 @OA\Property(property="idDepartamentoFK", type="integer", description="ID del departamento")
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
        $items = $this->municipioService->index($perPage);
        return response()->json($items);
    }
/**
 * @OA\Post(
 *     path="/api/municipio",
 *     tags={"Municipio"},
 *     summary="Crear un nuevo municipio",
 *     description="Crea un nuevo municipio con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información del municipio para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nombre", type="string", description="Nombre del municipio"),
 *             @OA\Property(property="idDepartamentoFK", type="integer", description="ID del departamento")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Municipio creado correctamente",
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
            'nombre' => 'required|string|max:50',
                    'idDepartamentoFK' => 'required|integer|exists:departamento,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new MunicipioDTO($request, $this->fields);
            $this->municipioService->store($dto);

            return response()->json(['message' => 'Municipio creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

/**
 * @OA\Get(
 *     path="/api/municipio/{id}",
 *     tags={"Municipio"},
 *     summary="Obtener un municipio",
 *     description="Retorna un municipio por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del municipio",
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
 *             @OA\Property(property="nombre", type="string", description="Nombre del municipio"),
 *             @OA\Property(property="idDepartamentoFK", type="integer", description="ID del departamento")
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
        $item = $this->municipioService->show($id);
        return response()->json($item);
    }

    /**
 * @OA\Put(
 *     path="/api/municipio/{id}",
 *     tags={"Municipio"},
 *     summary="Actualizar un municipio",
 *     description="Actualiza un municipio con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del municipio a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información del municipio para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nombre", type="string", description="Nombre del municipio"),
 *             @OA\Property(property="idDepartamentoFK", type="integer", description="ID del departamento")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipio actualizado correctamente",
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
            'nombre' => 'required|string|max:50',
                    'idDepartamentoFK' => 'required|integer|exists:departamento,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new MunicipioDTO($request, $this->fields);
            $this->municipioService->update($id, $dto);

            return response()->json(['message' => 'Municipio actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/municipio/{id}",
 *     tags={"Municipio"},
 *     summary="Eliminar un municipio",
 *     description="Elimina un municipio por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del municipio a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Municipio eliminado correctamente",
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
            $this->municipioService->destroy($id);

            return response()->json(['message' => 'Municipio eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
