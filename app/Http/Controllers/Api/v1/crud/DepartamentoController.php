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

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->departamentoService->index($perPage);
        return response()->json($items);
    }

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

    public function show($id)
    {
        $item = $this->departamentoService->show($id);
        return response()->json($item);
    }

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
