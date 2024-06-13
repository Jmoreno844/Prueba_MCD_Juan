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

    public function store($idInsumoFK, $idProveedorFK)
    {
        try {
            $insumoExists = DB::table('insumo')->where('id', $idInsumoFK)->exists();
            $proveedorExists = DB::table('proveedor')->where('id', $idProveedorFK)->exists();

            if (!$insumoExists || !$proveedorExists) {
                return response()->json(['message' => 'Invalid Insumo or Proveedor ID'], 422);
            }

            $insumoProveedor = DB::table('insumo_proveedor')->insert([
                'IdInsumoFK' => $idInsumoFK,
                'IdProveedorFK' => $idProveedorFK,
            ]);

            return response()->json($insumoProveedor, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($idInsumoFK, $idProveedorFK)
    {
        $insumoProveedor = DB::table('insumo_proveedor')->where('IdInsumoFK', $idInsumoFK)->where('IdProveedorFK', $idProveedorFK)->first();
        if ($insumoProveedor) {
            return response()->json($insumoProveedor);
        } else {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    public function destroy($idInsumoFK, $idProveedorFK)
    {
        try {
            $deletedRows = DB::table('insumo_proveedor')->where('IdInsumoFK', $idInsumoFK)->where('IdProveedorFK', $idProveedorFK)->delete();
            if ($deletedRows > 0) {
                return response()->json(['message' => 'Deleted successfully']);
            } else {
                return response()->json(['message' => 'Not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
