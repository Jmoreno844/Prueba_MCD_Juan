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
    protected $fields = ['NitProovedor', 'Nombre', 'IdTipoPersonaFK'];

    public function __construct(ProveedorService $proveedorService)
    {
        $this->proveedorService = $proveedorService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->proveedorService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NitProovedor' => 'required|string|max:50',
                    'Nombre' => 'required|string|max:50',
                    'IdTipoPersonaFK' => 'required|integer|exists:tipo_persona,id'
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

    public function show($id)
    {
        $item = $this->proveedorService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'NitProovedor' => 'required|string|max:50',
                    'Nombre' => 'required|string|max:50',
                    'IdTipoPersonaFK' => 'required|integer|exists:tipo_persona,id'
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