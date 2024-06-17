<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\ClienteDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\ClienteService;



class ClienteController extends Controller
{
    protected $clienteService;
    protected $fields = ['nombre', 'IdCliente', 'IdTipoPersonaFK', 'fechaRegistro', 'IdMunicipioFK'];

    public function __construct(ClienteService $clienteService)
    {
        $this->clienteService = $clienteService;
    }

    /**
 * @OA\Get(
 *     tags={"Clientes"},
 *     path="/api/clientes",
 *     summary="Obtener lista de clientes",
 *     @OA\Response(
 *         response=200,
 *         description="Lista de clientes"
 *     )
 * )
 */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $clientes = $this->clienteService->index($perPage);
        return response()->json($clientes);
    }

/**
 * @OA\Post(
 *     tags={"Clientes"},
 *     path="/api/clientes",
 *     summary="Crear un nuevo cliente",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="nombre",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="IdCliente",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="IdTipoPersonaFK",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="fechaRegistro",
 *                     type="string",
 *                     format="date"
 *                 ),
 * *                 @OA\Property(
 *                     property="IdMunicipioFK",
 *                     type="integer"
 *                 ),
 *                 example={"nombre": "Juan", "IdCliente": "123", "IdTipoPersonaFK": 1, "fechaRegistro": "2022-01-01T00:00:00Z", "IdMunicipioFK": 1}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cliente creado correctamente."
 *     )
 * )
 */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'IdCliente' => 'required|integer',
            'IdTipoPersonaFK' => 'required|integer',
            'fechaRegistro' => 'required|date',
            'IdMunicipioFK' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $clienteDTO = new ClienteDTO($request, $this->fields);
            $this->clienteService->store($clienteDTO);

            return response()->json(['message' => 'Cliente creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }



    /**
 * @OA\Get(
 *     tags={"Clientes"},
 *     path="/api/clientes/{id}",
 *     summary="Obtener un cliente específico",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del cliente a obtener",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cliente obtenido correctamente."
 *     )
 * )
 */
    public function show($id)
    {
        $cliente = $this->clienteService->show($id);
        return response()->json($cliente);
    }
/**
 * @OA\Put(
 *     tags={"Clientes"},
 *     path="/api/clientes/{id}",
 *     summary="Actualizar un cliente específico",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del cliente a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="nombre",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="IdCliente",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="IdTipoPersonaFK",
 *                     type="integer"
 *                 ),
 *                 @OA\Property(
 *                     property="fechaRegistro",
 *                     type="string",
 *                     format="date"
 *                 ),
 *                 @OA\Property(
 *                     property="IdMunicipioFK",
 *                     type="integer"
 *                 ),
 *                 example={"nombre": "Juan", "IdCliente": "123", "IdTipoPersonaFK": 1, "fechaRegistro": "2022-01-01T00:00:00Z", "IdMunicipioFK": 1}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cliente actualizado correctamente."
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'IdCliente' => 'required|integer',
            'IdTipoPersonaFK' => 'required|integer',
            'fechaRegistro' => 'required|date',
            'IdMunicipioFK' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $clienteDTO = new ClienteDTO($request, $this->fields);
            $this->clienteService->update($id, $clienteDTO);

            return response()->json(['message' => 'Cliente actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


/**
 * @OA\Delete(
 *     tags={"Clientes"},
 *     path="/api/clientes/{id}",
 *     summary="Eliminar un cliente específico",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del cliente a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cliente eliminado correctamente."
 *     )
 * )
 */
    public function destroy($id)
    {
        try {
            $this->clienteService->destroy($id);

            return response()->json(['message' => 'Cliente eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
