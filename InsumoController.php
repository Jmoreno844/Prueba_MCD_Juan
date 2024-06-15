<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\InsumoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InsumoService;

class InsumoController extends Controller
{
    protected $insumoService;
    protected $fields = ['nombre', 'valor_unit', 'stock_min', 'stock_max'];

    public function __construct(InsumoService $insumoService)
    {
        $this->insumoService = $insumoService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->insumoService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
                    'valor_unit' => 'required|numeric',
                    'stock_min' => 'required|numeric',
                    'stock_max' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InsumoDTO($request, $this->fields);
            $this->insumoService->store($dto);

            return response()->json(['message' => 'Insumo creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->insumoService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
                    'valor_unit' => 'required|numeric',
                    'stock_min' => 'required|numeric',
                    'stock_max' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InsumoDTO($request, $this->fields);
            $this->insumoService->update($id, $dto);

            return response()->json(['message' => 'Insumo actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->insumoService->destroy($id);

            return response()->json(['message' => 'Insumo eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}