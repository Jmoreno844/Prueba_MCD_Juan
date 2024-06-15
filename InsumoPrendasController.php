<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\InsumoPrendasDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InsumoPrendasService;

class InsumoPrendasController extends Controller
{
    protected $insumoprendasService;
    protected $fields = ['IdInsumoFk', 'IdPrendaFk', 'Cantidad'];

    public function __construct(InsumoPrendasService $insumoprendasService)
    {
        $this->insumoprendasService = $insumoprendasService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->insumoprendasService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdInsumoFk' => 'required|integer',
                    'IdPrendaFk' => 'required|integer',
                    'Cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InsumoPrendasDTO($request, $this->fields);
            $this->insumoprendasService->store($dto);

            return response()->json(['message' => 'InsumoPrendas creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->insumoprendasService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'IdInsumoFk' => 'required|integer',
                    'IdPrendaFk' => 'required|integer',
                    'Cantidad' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InsumoPrendasDTO($request, $this->fields);
            $this->insumoprendasService->update($id, $dto);

            return response()->json(['message' => 'InsumoPrendas actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->insumoprendasService->destroy($id);

            return response()->json(['message' => 'InsumoPrendas eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}