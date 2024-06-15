<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\EstadoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\EstadoService;

class EstadoController extends Controller
{
    protected $estadoService;
    protected $fields = ['Descripcion'];

    public function __construct(EstadoService $estadoService)
    {
        $this->estadoService = $estadoService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->estadoService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EstadoDTO($request, $this->fields);
            $this->estadoService->store($dto);

            return response()->json(['message' => 'Estado creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->estadoService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EstadoDTO($request, $this->fields);
            $this->estadoService->update($id, $dto);

            return response()->json(['message' => 'Estado actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->estadoService->destroy($id);

            return response()->json(['message' => 'Estado eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}