<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\EmpresaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\EmpresaService;

class EmpresaController extends Controller
{
    protected $empresaService;
    protected $fields = ['nit', 'razon_social', 'representante_legal', 'FechaCreacion', 'IdMunicipioFk'];

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->empresaService->index($perPage);
        return response()->json($items);
    }

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

    public function show($id)
    {
        $item = $this->empresaService->show($id);
        return response()->json($item);
    }

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