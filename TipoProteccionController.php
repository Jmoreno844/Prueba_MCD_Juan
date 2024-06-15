<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\TipoProteccionDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\TipoProteccionService;

class TipoProteccionController extends Controller
{
    protected $tipoproteccionService;
    protected $fields = ['Descripcion'];

    public function __construct(TipoProteccionService $tipoproteccionService)
    {
        $this->tipoproteccionService = $tipoproteccionService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->tipoproteccionService->index($perPage);
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
            $dto = new TipoProteccionDTO($request, $this->fields);
            $this->tipoproteccionService->store($dto);

            return response()->json(['message' => 'TipoProteccion creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->tipoproteccionService->show($id);
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
            $dto = new TipoProteccionDTO($request, $this->fields);
            $this->tipoproteccionService->update($id, $dto);

            return response()->json(['message' => 'TipoProteccion actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tipoproteccionService->destroy($id);

            return response()->json(['message' => 'TipoProteccion eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}