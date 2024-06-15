<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\ColorDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\ColorService;

class ColorController extends Controller
{
    protected $colorService;
    protected $fields = ['Descripcion'];

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->colorService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new ColorDTO($request, $this->fields);
            $this->colorService->store($dto);

            return response()->json(['message' => 'Color creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->colorService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new ColorDTO($request, $this->fields);
            $this->colorService->update($id, $dto);

            return response()->json(['message' => 'Color actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->colorService->destroy($id);

            return response()->json(['message' => 'Color eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}