<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\DetalleOrdenDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\DetalleOrdenService;

class DetalleOrdenController extends Controller
{
    protected $detalleOrdenService;
    protected $fields = ['IdOrdenFk', 'IdPrendaFk', 'IdColorFK', 'IdTallaFK', 'PrendaId', 'cantidad_producir', 'cantidad_producida', 'IdEstadoFk'];

    public function __construct(DetalleOrdenService $detalleOrdenService)
    {
        $this->detalleOrdenService = $detalleOrdenService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->detalleOrdenService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdOrdenFk' => 'required|integer',
                    'IdPrendaFk' => 'required|integer',
                    'IdColorFK' => 'required|integer',
                    'IdTallaFK' => 'required|integer',
                    'PrendaId' => 'required|integer',
                    'cantidad_producir' => 'required|integer',
                    'cantidad_producida' => 'required|integer',
                    'IdEstadoFk' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DetalleOrdenDTO($request, $this->fields);
            $this->detalleOrdenService->store($dto);

            return response()->json(['message' => 'DetalleOrden creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->detalleOrdenService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'IdOrdenFk' => 'required|integer',
                    'IdPrendaFk' => 'required|integer',
                    'IdColorFK' => 'required|integer',
                    'IdTallaFK' => 'required|integer',
                    'PrendaId' => 'required|integer',
                    'cantidad_producir' => 'required|integer',
                    'cantidad_producida' => 'required|integer',
                    'IdEstadoFk' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new DetalleOrdenDTO($request, $this->fields);
            $this->detalleOrdenService->update($id, $dto);

            return response()->json(['message' => 'DetalleOrden actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->detalleOrdenService->destroy($id);

            return response()->json(['message' => 'DetalleOrden eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}