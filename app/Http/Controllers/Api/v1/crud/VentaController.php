<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\VentaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\VentaService;

class VentaController extends Controller
{
    protected $ventaService;
    protected $fields = ['Fecha',"IdEmpleadoFK", 'IdClienteFK', 'IdFormaPagoFK'];

    public function __construct(VentaService $ventaService)
    {
        $this->ventaService = $ventaService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->ventaService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'Fecha' => 'required|date',
                    'IdClienteFK' => 'required|integer|exists:cliente,id',
                    'IdFormaPagoFK' => 'required|integer|exists:forma_pago,id',
                    'IdEmpleadoFK' => 'required|integer|exists:empleado,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new VentaDTO($request, $this->fields);
            $this->ventaService->store($dto);

            return response()->json(['message' => 'Venta creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->ventaService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Fecha' => 'required|date',
            'IdClienteFK' => 'required|integer|exists:cliente,id',
            'IdFormaPagoFK' => 'required|integer|exists:forma_pago,id',
            'IdEmpleadoFK' => 'required|integer|exists:empleado,id'
]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new VentaDTO($request, $this->fields);
            $this->ventaService->update($id, $dto);

            return response()->json(['message' => 'Venta actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->ventaService->destroy($id);

            return response()->json(['message' => 'Venta eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
