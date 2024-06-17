<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\EmpresaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\EmpresaService;


class EmpresaController extends Controller
{
    protected $empresaService;
    protected $fields = ['nit', 'razon_social', 'representante_legal', 'FechaCreacion', 'IdMunicipioFk'];

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    /**
     * @OA\Get(
     *     path="/api/empresa",
     *     tags={"Empresa"},
     *     summary="Obtener todas las empresas",
     *     description="Retorna una lista de empresas",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="nit", type="string"),
     *                 @OA\Property(property="razon_social", type="string"),
     *                 @OA\Property(property="representante_legal", type="string"),
     *                 @OA\Property(property="FechaCreacion", type="string", format="date"),
     *                 @OA\Property(property="IdMunicipioFk", type="integer")
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
        $items = $this->empresaService->index($perPage);
        return response()->json($items);
    }

    /**
     * @OA\Post(
     *     path="/api/empresa",
     *     tags={"Empresa"},
     *     summary="Crear una nueva empresa",
     *     description="Crea una nueva empresa y la retorna",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nit", type="string"),
     *             @OA\Property(property="razon_social", type="string"),
     *             @OA\Property(property="representante_legal", type="string"),
     *             @OA\Property(property="FechaCreacion", type="string", format="date"),
     *             @OA\Property(property="IdMunicipioFk", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa creada correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
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
            'nit' => 'required|max:50',
            'razon_social' => 'required',
            'representante_legal' => 'required|max:50',
            'FechaCreacion' => 'required|date',
            'IdMunicipioFk' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EmpresaDTO($request, $this->fields);
            $this->empresaService->store($dto);

            return response()->json(['message' => 'Empresa creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/empresa/{id}",
     *     tags={"Empresa"},
     *     summary="Obtener una empresa por ID",
     *     description="Retorna una empresa por su ID",
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
     *             @OA\Property(property="nit", type="string"),
     *             @OA\Property(property="razon_social", type="string"),
     *             @OA\Property(property="representante_legal", type="string"),
     *             @OA\Property(property="FechaCreacion", type="string", format="date"),
     *             @OA\Property(property="IdMunicipioFk", type="integer")
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
        $item = $this->empresaService->show($id);
        return response()->json($item);
    }

    /**
     * @OA\Put(
     *     path="/api/empresa/{id}",
     *     tags={"Empresa"},
     *     summary="Actualizar una empresa por ID",
     *     description="Actualiza una empresa por su ID",
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
     *             @OA\Property(property="nit", type="string"),
     *             @OA\Property(property="razon_social", type="string"),
     *             @OA\Property(property="representante_legal", type="string"),
     *             @OA\Property(property="FechaCreacion", type="string", format="date"),
     *             @OA\Property(property="IdMunicipioFk", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa actualizada correctamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
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
            'nit' => 'required|max:50',
            'razon_social' => 'required',
            'representante_legal' => 'required|max:50',
            'FechaCreacion' => 'required|date',
            'IdMunicipioFk' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EmpresaDTO($request, $this->fields);
            $this->empresaService->update($id, $dto);

            return response()->json(['message' => 'Empresa actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/empresa/{id}",
     *     tags={"Empresa"},
     *     summary="Eliminar una empresa por ID",
     *     description="Elimina una empresa por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empresa eliminada correctamente",
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
            $this->empresaService->destroy($id);

            return response()->json(['message' => 'Empresa eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
