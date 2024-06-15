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

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->municipioService->index($perPage);
        return response()->json($items);
    }

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

    public function show($id)
    {
        $item = $this->municipioService->show($id);
        return response()->json($item);
    }

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