<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InsumoPrendasService;

class InsumoPrendasController extends Controller
{
    protected $insumoPrendasService;
    protected $fields = ['IdInsumoFk', 'IdPrendaFk', 'Cantidad'];

    public function __construct(InsumoPrendasService $insumoPrendasService)
    {
        $this->insumoPrendasService = $insumoPrendasService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->insumoPrendasService->index($perPage);
        return response()->json($items);
    }

    public function store($idInsumoFK, $idPrendaFK,Request $request)
    {
        $data = [
            'IdInsumoFk' => $idInsumoFK,
            'IdPrendaFk' => $idPrendaFK,
            'Cantidad' => $request->input('Cantidad')
        ];

        $rules = [
            'IdInsumoFk' => 'required|integer|exists:insumo,id',
            'IdPrendaFk' => 'required|integer|exists:prenda,id',
            'Cantidad' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);

        $cantidad = $validator->getData()['Cantidad'];
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $this->insumoPrendasService->store($idInsumoFK, $idPrendaFK, $cantidad);

            return response()->json(['message' => 'InsumoPrendas creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($idInsumoFK, $idPrendaFK)
    {
        $item = $this->insumoPrendasService->show($idInsumoFK, $idPrendaFK);
        return response()->json($item);
    }

    public function update($idInsumoFK,$idPrendaFK,Request $request)
    {
        $data = [
            'IdInsumoFk' => $idInsumoFK,
            'IdPrendaFk' => $idPrendaFK,
            'Cantidad' => $request->input('Cantidad')
        ];

        $rules = [
            'IdInsumoFk' => 'required|integer|exists:insumo,id',
            'IdPrendaFk' => 'required|integer|exists:prenda,id',
            'Cantidad' => 'required|integer'
        ];

        $validator = Validator::make($data, $rules);

        $cantidad = $validator->getData()['Cantidad'];

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $this->insumoPrendasService->update($idInsumoFK, $idPrendaFK, $cantidad);

            return response()->json(['message' => 'InsumoPrendas actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($idInsumoFK, $idPrendaFK)
    {
        try {
            $this->insumoPrendasService->destroy($idInsumoFK, $idPrendaFK);

            return response()->json(['message' => 'InsumoPrendas eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
