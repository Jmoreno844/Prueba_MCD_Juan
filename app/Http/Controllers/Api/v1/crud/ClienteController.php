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

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $clientes = $this->clienteService->index($perPage);
        return response()->json($clientes);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'IdCliente' => 'required|max:50',
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

    public function show($id)
    {
        $cliente = $this->clienteService->show($id);
        return response()->json($cliente);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
            'IdCliente' => 'required|max:50',
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
