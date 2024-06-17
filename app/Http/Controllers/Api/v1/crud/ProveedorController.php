<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\ProveedorDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\ProveedorService;

class ProveedorController extends Controller
{
    protected $proveedorService;
    protected $fields = ['NitProovedor', 'Nombre', 'IdTipoPersona',"IdMunicipioFK"];

    public function __construct(ProveedorService $proveedorService)
    {
        $this->proveedorService = $proveedorService;
    }

    /**
 * @OA\Get(
 *     path="/api/proveedor",
 *     tags={"Proveedor"},
 *     summary="Obtener lista de proveedores",
 *     description="Retorna una lista de proveedores",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="NitProovedor", type="string", description="Nit del proveedor"),
 *                 @OA\Property(property="Nombre", type="string", description="Nombre del proveedor"),
 *                 @OA\Property(property="IdTipoPersona", type="integer", description="ID del tipo de persona"),
 *                 @OA\Property(property="IdMunicipioFK", type="integer", description="ID del municipio")
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
        $items = $this->proveedorService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/proveedor",
 *     tags={"Proveedor"},
 *     summary="Crear un nuevo proveedor",
 *     description="Crea un nuevo proveedor con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información del proveedor para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="NitProovedor", type="string", description="Nit del proveedor"),
 *             @OA\Property(property="Nombre", type="string", description="Nombre del proveedor"),
 *             @OA\Property(property="IdTipoPersona", type="integer", description="ID del tipo de persona"),
 *             @OA\Property(property="IdMunicipioFK", type="integer", description="ID del municipio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Proveedor creado correctamente",
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
            'NitProovedor' => 'required|string|max:50',
            'Nombre' => 'required|string|max:50',
            'IdTipoPersona' => 'required|integer|exists:tipo_persona,id',
            'IdMunicipioFK' => 'required|integer|exists:municipio,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new ProveedorDTO($request, $this->fields);
            $this->proveedorService->store($dto);

            return response()->json(['message' => 'Proveedor creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

/**
 * @OA\Get(
 *     path="/api/proveedor/{id}",
 *     tags={"Proveedor"},
 *     summary="Obtener un proveedor",
 *     description="Retorna un proveedor por su ID",
 *     @OA\Parameter(
 *         name="id",
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
 *             @OA\Property(property="NitProovedor", type="string", description="Nit del proveedor"),
 *             @OA\Property(property="Nombre", type="string", description="Nombre del proveedor"),
 *             @OA\Property(property="IdTipoPersona", type="integer", description="ID del tipo de persona"),
 *             @OA\Property(property="IdMunicipioFK", type="integer", description="ID del municipio")
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
        $item = $this->proveedorService->show($id);
        return response()->json($item);
    }


/**
 * @OA\Put(
 *     path="/api/proveedor/{id}",
 *     tags={"Proveedor"},
 *     summary="Actualizar un proveedor",
 *     description="Actualiza un proveedor con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del proveedor a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información del proveedor para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="NitProovedor", type="string", description="Nit del proveedor"),
 *             @OA\Property(property="Nombre", type="string", description="Nombre del proveedor"),
 *             @OA\Property(property="IdTipoPersona", type="integer", description="ID del tipo de persona"),
 *             @OA\Property(property="IdMunicipioFK", type="integer", description="ID del municipio")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Proveedor actualizado correctamente",
 *     ),
 *      @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'NitProovedor' => 'required|string|max:50',
            'Nombre' => 'required|string|max:50',
            'IdTipoPersona' => 'required|integer|exists:tipo_persona,id',
            'IdMunicipioFK' => 'required|integer|exists:municipio,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new ProveedorDTO($request, $this->fields);
            $this->proveedorService->update($id, $dto);

            return response()->json(['message' => 'Proveedor actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/proveedor/{id}",
 *     tags={"Proveedor"},
 *     summary="Eliminar un proveedor",
 *     description="Elimina un proveedor por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del proveedor a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Proveedor eliminado correctamente",
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
            $this->proveedorService->destroy($id);

            return response()->json(['message' => 'Proveedor eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
