<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\DepartamentoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\DepartamentoService;

class DepartamentoController extends Controller
{
    protected $departamentoService;
    protected $fields = ['nombre', 'IdPaisFK'];

    public function __construct(DepartamentoService $departamentoService)
    {
        $this->departamentoService = $departamentoService;
    }


/**
     * @OA\Get(
     *     path="/api/departamento",
     *     tags={"Departamento"},
     *     summary="Get list of departamentos",
     *     description="Returns list of departamentos",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->departamentoService->index($perPage);
        return response()->json($items);
    }


    /**
     * @OA\Post(
     *     path="/api/departamento",
     *     tags={"Departamento"},
     *     summary="Store new departamento",
     *     description="Returns departamento data",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Departamento to store",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="nombre",
     *                 description="Nombre del departamento",
     *                 type="string",
     *                 maxLength=50
     *             ),
     *             @OA\Property(
     *                 property="IdPaisFK",
     *                 description="Foreign key of Pais",
     *                 type="integer"
     *             )
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'IdPaisFK' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DepartamentoDTO($request, $this->fields);
            $this->departamentoService->store($dto);

            return response()->json(['message' => 'Departamento creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


 /**
     * @OA\Get(
     *     path="/api/departamento/{id}",
     *     tags={"Departamento"},
     *     summary="Get departamento by id",
     *     description="Returns departamento data",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of departamento that needs to be fetched",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function show($id)
    {
        $item = $this->departamentoService->show($id);
        return response()->json($item);
    }


     /**
     * @OA\Put(
     *     path="/api/departamento/{id}",
     *     tags={"Departamento"},
     *     summary="Update an existing departamento",
     *     description="Returns updated departamento data",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of departamento that needs to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\RequestBody(
     *         description="Departamento to update",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="nombre",
     *                 description="Nombre del departamento",
     *                 type="string",
     *                 maxLength=50
     *             ),
     *             @OA\Property(
     *                 property="IdPaisFK",
     *                 description="Foreign key of Pais",
     *                 type="integer"
     *             )
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
                    'IdPaisFK' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DepartamentoDTO($request, $this->fields);
            $this->departamentoService->update($id, $dto);

            return response()->json(['message' => 'Departamento actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


     /**
     * @OA\Delete(
     *     path="/api/departamento/{id}",
     *     tags={"Departamento"},
     *     summary="Delete an existing departamento",
     *     description="Deletes departamento data",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of departamento that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int32"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->departamentoService->destroy($id);

            return response()->json(['message' => 'Departamento eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
