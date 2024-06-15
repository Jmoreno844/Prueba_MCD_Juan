<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\InventarioDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InventarioService;

class InventarioController extends Controller
{
    protected $inventarioService;
    protected $fields = ['CodInv', 'IdPrendaFk', 'IdTallaFK', 'IdColorFK', 'Cantidad'];

    public function __construct(InventarioService $inventarioService)
    {
        $this->inventarioService = $inventarioService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->inventarioService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CodInv' => 'required|string|max:255',
                    'IdPrendaFk' => 'required|integer|exists:prenda,id',
                    'IdTallaFK' => 'required|integer|exists:talla,id',
                    'IdColorFK' => 'required|integer|exists:color,id',
                    'Cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InventarioDTO($request, $this->fields);
            $this->inventarioService->store($dto);

            return response()->json(['message' => 'Inventario creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->inventarioService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'CodInv' => 'required|string|max:255',
                    'IdPrendaFk' => 'required|integer|exists:prenda,id',
                    'IdTallaFK' => 'required|integer|exists:talla,id',
                    'IdColorFK' => 'required|integer|exists:color,id',
                    'Cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InventarioDTO($request, $this->fields);
            $this->inventarioService->update($id, $dto);

            return response()->json(['message' => 'Inventario actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->inventarioService->destroy($id);

            return response()->json(['message' => 'Inventario eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}