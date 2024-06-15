<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\TipoPersonaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\TipoPersonaService;

class TipoPersonaController extends Controller
{
    protected $tipopersonaService;
    protected $fields = ['Descripcion'];

    public function __construct(TipoPersonaService $tipopersonaService)
    {
        $this->tipopersonaService = $tipopersonaService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->tipopersonaService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new TipoPersonaDTO($request, $this->fields);
            $this->tipopersonaService->store($dto);

            return response()->json(['message' => 'TipoPersona creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->tipopersonaService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new TipoPersonaDTO($request, $this->fields);
            $this->tipopersonaService->update($id, $dto);

            return response()->json(['message' => 'TipoPersona actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tipopersonaService->destroy($id);

            return response()->json(['message' => 'TipoPersona eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}