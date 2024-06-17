<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\EmpleadoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\EmpleadoService;

class EmpleadoController extends Controller
{
    protected $empleadoService;
    protected $fields = ['nombre', 'idCargoFK', 'fecha_ingreso', 'IdMunicipioFK'];

    public function __construct(EmpleadoService $empleadoService)
    {
        $this->empleadoService = $empleadoService;
    }

    /**
     * @OA\Get(
     *     path="/api/empleado",
     *     tags={"Empleado"},
     *     summary="Obtener todos los empleados",
     *     description="Retorna una lista de empleados",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="nombre", type="string"),
     *                 @OA\Property(property="idCargoFK", type="integer"),
     *                 @OA\Property(property="fecha_ingreso", type="string", format="date"),
     *                 @OA\Property(property="IdMunicipioFK", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->empleadoService->index($perPage);
        return response()->json($items);
    }

    /**
     * @OA\Post(
     *     path="/api/empleado",
     *     tags={"Empleado"},
     *     summary="Crear un nuevo empleado",
     *     description="Crea un nuevo empleado y lo retorna",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="idCargoFK", type="integer"),
     *             @OA\Property(property="fecha_ingreso", type="string", format="date"),
     *             @OA\Property(property="IdMunicipioFK", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado creado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="idCargoFK", type="integer"),
     *             @OA\Property(property="fecha_ingreso", type="string", format="date"),
     *             @OA\Property(property="IdMunicipioFK", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'idCargoFK' => 'required|integer',
            'fecha_ingreso' => 'required|date',
            'IdMunicipioFK' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EmpleadoDTO($request, $this->fields);
            $this->empleadoService->store($dto);

            return response()->json(['message' => 'Empleado creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/empleado/{id}",
     *     tags={"Empleado"},
     *     summary="Obtener un empleado",
     *     description="Retorna un empleado por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="idCargoFK", type="integer"),
     *             @OA\Property(property="fecha_ingreso", type="string", format="date"),
     *             @OA\Property(property="IdMunicipioFK", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function show($id)
    {
        $item = $this->empleadoService->show($id);
        return response()->json($item);
    }

    /**
     * @OA\Put(
     *     path="/api/empleado/{id}",
     *     tags={"Empleado"},
     *     summary="Actualizar un empleado",
     *     description="Actualiza un empleado por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="idCargoFK", type="integer"),
     *             @OA\Property(property="fecha_ingreso", type="string", format="date"),
     *             @OA\Property(property="IdMunicipioFK", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado actualizado correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="idCargoFK", type="integer"),
     *             @OA\Property(property="fecha_ingreso", type="string", format="date"),
     *             @OA\Property(property="IdMunicipioFK", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error del servidor"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'idCargoFK' => 'required|integer',
            'fecha_ingreso' => 'required|date',
            'IdMunicipioFK' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EmpleadoDTO($request, $this->fields);
            $this->empleadoService->update($id, $dto);

            return response()->json(['message' => 'Empleado actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/empleado/{id}",
     *     tags={"Empleado"},
     *     summary="Eliminar un empleado",
     *     description="Elimina un empleado por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado eliminado correctamente",
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
            $this->empleadoService->destroy($id);

            return response()->json(['message' => 'Empleado eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
