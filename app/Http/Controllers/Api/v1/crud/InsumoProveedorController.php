<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InsumoProveedorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $insumoProveedor = DB::table('insumo_proveedor')->paginate($perPage);
        return response()->json($insumoProveedor);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'IdInsumoFK' => 'required|integer|exists:insumo,id',
                'IdProveedorFK' => 'required|integer|exists:proveedor,id',
            ]);

            $insumoProveedor = DB::table('insumo_proveedor')->insert([
                'IdInsumoFK' => $validatedData['IdInsumoFK'],
                'IdProveedorFK' => $validatedData['IdProveedorFK'],
            ]);

            return response()->json($insumoProveedor);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($idInsumoFK, $idProveedorFK)
    {
        $insumoProveedor = DB::table('insumo_proveedor')->where('IdInsumoFK', $idInsumoFK)->where('IdProveedorFK', $idProveedorFK)->first();
        return response()->json($insumoProveedor);
    }

    public function destroy($idInsumoFK, $idProveedorFK)
    {
        try {
            DB::table('insumo_proveedor')->where('IdInsumoFK', $idInsumoFK)->where('IdProveedorFK', $idProveedorFK)->delete();
            return response()->json(['message' => 'InsumoProveedor eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
