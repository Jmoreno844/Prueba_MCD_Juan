<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\InsumoProveedorDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InsumoProveedorService;

class InsumoProveedorController extends Controller
{
    protected $insumoProveedorService;
    protected $fields = ['IdInsumoFK', 'IdProveedorFK'];

    public function __construct(InsumoProveedorService $insumoProveedorService)
    {
        $this->insumoProveedorService = $insumoProveedorService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->insumoProveedorService->index($perPage);
        return response()->json($items);
    }

    public function store($idInsumoFK, $idProveedorFK)
    {
        $data = [
            'idInsumoFK' => $idInsumoFK,
            'idProveedorFK' => $idProveedorFK
        ];

        $rules = [
            'idInsumoFK' => 'required|integer|exists:insumo,id',
            'idProveedorFK' => 'required|integer|exists:proveedor,id'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $this->insumoProveedorService->store($idInsumoFK, $idProveedorFK);

            return response()->json(['message' => 'InsumoProveedor creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($idInsumoFK, $idProveedorFK )
    {
        $item = $this->insumoProveedorService->show($idInsumoFK,$idProveedorFK);
        if(!$item){
            return response()->json(['message' => 'InsumoProveedor no encontrado.'], 404);
        }
        return response()->json(["message" => "InsumoProveedor existe en (Insumo,Proovedor) = (".$idInsumoFK.",".$idProveedorFK.")."],200);

    }



    public function destroy($idInsumoFK, $idProveedorFK)
    {
        try {
            $this->insumoProveedorService->destroy($idInsumoFK, $idProveedorFK);

            return response()->json(['message' => 'InsumoProveedor eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
