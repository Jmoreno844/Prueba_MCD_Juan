<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\OrdenDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\OrdenService;

class OrdenController extends Controller
{
    protected $ordenService;
    protected $fields = ['fecha', 'IdEmpleadoFK', 'IdClienteFK', 'IdEstadoFK'];

    public function __construct(OrdenService $ordenService)
    {
        $this->ordenService = $ordenService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->ordenService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
                    'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                    'IdClienteFK' => 'required|integer|exists:cliente,id',
                    'IdEstadoFK' => 'required|integer|exists:estado,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new OrdenDTO($request, $this->fields);
            $this->ordenService->store($dto);

            return response()->json(['message' => 'Orden creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->ordenService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|date',
                    'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                    'IdClienteFK' => 'required|integer|exists:cliente,id',
                    'IdEstadoFK' => 'required|integer|exists:estado,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new OrdenDTO($request, $this->fields);
            $this->ordenService->update($id, $dto);

            return response()->json(['message' => 'Orden actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->ordenService->destroy($id);

            return response()->json(['message' => 'Orden eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}