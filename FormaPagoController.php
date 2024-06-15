<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\FormaPagoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\FormaPagoService;

class FormaPagoController extends Controller
{
    protected $formapagoService;
    protected $fields = ['Descripcion'];

    public function __construct(FormaPagoService $formapagoService)
    {
        $this->formapagoService = $formapagoService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->formapagoService->index($perPage);
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
            $dto = new FormaPagoDTO($request, $this->fields);
            $this->formapagoService->store($dto);

            return response()->json(['message' => 'FormaPago creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->formapagoService->show($id);
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
            $dto = new FormaPagoDTO($request, $this->fields);
            $this->formapagoService->update($id, $dto);

            return response()->json(['message' => 'FormaPago actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->formapagoService->destroy($id);

            return response()->json(['message' => 'FormaPago eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}