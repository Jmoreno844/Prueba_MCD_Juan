<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\DetalleVentaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\DetalleVentaService;

class DetalleVentaController extends Controller
{
    protected $detalleventaService;
    protected $fields = ['IdVentaFk', 'IdInventarioFK', 'cantidad'];

    public function __construct(DetalleVentaService $detalleventaService)
    {
        $this->detalleventaService = $detalleventaService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->detalleventaService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdVentaFk' => 'required|integer',
                    'IdInventarioFK' => 'required|integer',
                    'cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DetalleVentaDTO($request, $this->fields);
            $this->detalleventaService->store($dto);

            return response()->json(['message' => 'DetalleVenta creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->detalleventaService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'IdVentaFk' => 'required|integer',
                    'IdInventarioFK' => 'required|integer',
                    'cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DetalleVentaDTO($request, $this->fields);
            $this->detalleventaService->update($id, $dto);

            return response()->json(['message' => 'DetalleVenta actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->detalleventaService->destroy($id);

            return response()->json(['message' => 'DetalleVenta eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}