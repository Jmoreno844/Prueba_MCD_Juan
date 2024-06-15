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
    protected $tipoPersonaService;
    protected $fields = ['nombre'];

    public function __construct(TipoPersonaService $tipoPersonaService)
    {
        $this->tipoPersonaService = $tipoPersonaService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->tipoPersonaService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new TipoPersonaDTO($request, $this->fields);
            $this->tipoPersonaService->store($dto);

            return response()->json(['message' => 'TipoPersona creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->tipoPersonaService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new TipoPersonaDTO($request, $this->fields);
            $this->tipoPersonaService->update($id, $dto);

            return response()->json(['message' => 'TipoPersona actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tipoPersonaService->destroy($id);

            return response()->json(['message' => 'TipoPersona eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
