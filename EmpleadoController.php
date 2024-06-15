<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\EmpleadoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\EmpleadoService;

class EmpleadoController extends Controller
{
    protected $empleadoService;
    protected $fields = ['nombre', 'idCargoFK', 'fecha_ingreso', 'IdMunicipioFK'];

    public function __construct(EmpleadoService $empleadoService)
    {
        $this->empleadoService = $empleadoService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->empleadoService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
                    'idCargoFK' => 'required|integer',
                    'fecha_ingreso' => 'required|date',
                    'IdMunicipioFK' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EmpleadoDTO($request, $this->fields);
            $this->empleadoService->store($dto);

            return response()->json(['message' => 'Empleado creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->empleadoService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:50',
                    'idCargoFK' => 'required|integer',
                    'fecha_ingreso' => 'required|date',
                    'IdMunicipioFK' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EmpleadoDTO($request, $this->fields);
            $this->empleadoService->update($id, $dto);

            return response()->json(['message' => 'Empleado actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->empleadoService->destroy($id);

            return response()->json(['message' => 'Empleado eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}