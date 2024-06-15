<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\PrendaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\PrendaService;

class PrendaController extends Controller
{
    protected $prendaService;
    protected $fields = ['Nombre', 'ValorUnitCop', 'ValorUnitUsd', 'IdEstadoFK', 'IdTipoProteccionFK', 'IdGeneroFK', 'Codigo'];

    public function __construct(PrendaService $prendaService)
    {
        $this->prendaService = $prendaService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->prendaService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|string|max:50',
                    'ValorUnitCop' => 'required|numeric',
                    'ValorUnitUsd' => 'required|numeric',
                    'IdEstadoFK' => 'required|integer|exists:estado,id',
                    'IdTipoProteccionFK' => 'required|integer|exists:tipo_proteccion,id',
                    'IdGeneroFK' => 'required|integer|exists:genero,id',
                    'Codigo' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new PrendaDTO($request, $this->fields);
            $this->prendaService->store($dto);

            return response()->json(['message' => 'Prenda creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->prendaService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Nombre' => 'required|string|max:50',
                    'ValorUnitCop' => 'required|numeric',
                    'ValorUnitUsd' => 'required|numeric',
                    'IdEstadoFK' => 'required|integer|exists:estado,id',
                    'IdTipoProteccionFK' => 'required|integer|exists:tipo_proteccion,id',
                    'IdGeneroFK' => 'required|integer|exists:genero,id',
                    'Codigo' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new PrendaDTO($request, $this->fields);
            $this->prendaService->update($id, $dto);

            return response()->json(['message' => 'Prenda actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->prendaService->destroy($id);

            return response()->json(['message' => 'Prenda eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}