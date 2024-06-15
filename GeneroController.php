<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\GeneroDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\GeneroService;

class GeneroController extends Controller
{
    protected $generoService;
    protected $fields = ['descripcion'];

    public function __construct(GeneroService $generoService)
    {
        $this->generoService = $generoService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->generoService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new GeneroDTO($request, $this->fields);
            $this->generoService->store($dto);

            return response()->json(['message' => 'Genero creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->generoService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'descripcion' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new GeneroDTO($request, $this->fields);
            $this->generoService->update($id, $dto);

            return response()->json(['message' => 'Genero actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->generoService->destroy($id);

            return response()->json(['message' => 'Genero eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}