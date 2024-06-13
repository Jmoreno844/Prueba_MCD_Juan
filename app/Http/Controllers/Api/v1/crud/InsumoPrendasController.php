<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InsumoPrendasController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $insumoPrendas = DB::table('insumo_prendas')->paginate($perPage);
        return response()->json($insumoPrendas);
    }


    public function store(Request $request, $idInsumoFk, $idPrendaFk)
    {
        try {
            $validatedData = $request->validate([
                'Cantidad' => 'required|integer',
            ]);

            // Ensure the IDs exist in their respective tables
            $insumoExists = DB::table('insumo')->where('id', $idInsumoFk)->exists();
            $prendaExists = DB::table('prenda')->where('id', $idPrendaFk)->exists();

            if (!$insumoExists || !$prendaExists) {
                return response()->json(['message' => 'Invalid Insumo or Prenda ID'], 422);
            }

            $insumoPrenda = DB::table('insumo_prendas')->insert([
                'IdInsumoFk' => $idInsumoFk,
                'IdPrendaFk' => $idPrendaFk,
                'Cantidad' => $validatedData['Cantidad'],
            ]);

            return response()->json($insumoPrenda, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($idInsumoFK, $idPrendaFK)
    {
        $insumoPrenda = DB::table('insumo_prendas')->where('IdInsumoFK', $idInsumoFK)->where('IdPrendaFK', $idPrendaFK)->first();
        if ($insumoPrenda) {
            return response()->json($insumoPrenda);
        } else {
            return response()->json(['message' => 'Not found'], 404);
        }
    }

    public function update(Request $request, $idInsumoFk, $idPrendaFk)
    {
        try {
            $validatedData = $request->validate([
                'Cantidad' => 'required|integer',
            ]);

            $updatedRows = DB::table('insumo_prendas')->where('IdInsumoFk', $idInsumoFk)->where('IdPrendaFk', $idPrendaFk)->update([
                'Cantidad' => $validatedData['Cantidad'],
            ]);

            if ($updatedRows > 0) {
                return response()->json(['message' => 'Updated successfully']);
            } else {
                return response()->json(['message' => 'Not found'], 404);
            }
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($idInsumoFK, $idPrendaFK)
    {
        try {
            $deletedRows = DB::table('insumo_prendas')->where('IdInsumoFK', $idInsumoFK)->where('IdPrendaFK', $idPrendaFK)->delete();
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
