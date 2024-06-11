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

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'IdInsumoFK' => 'required|integer|exists:insumo,id',
                'IdPrendaFK' => 'required|integer|exists:prenda,id',
                'Cantidad' => 'required|integer',
            ]);

            $insumoPrenda = DB::table('insumo_prendas')->insert([
                'IdInsumoFK' => $validatedData['IdInsumoFK'],
                'IdPrendaFK' => $validatedData['IdPrendaFK'],
                'Cantidad' => $validatedData['Cantidad'],
            ]);

            return response()->json($insumoPrenda);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($idInsumoFK, $idPrendaFK)
    {
        $insumoPrenda = DB::table('insumo_prendas')->where('IdInsumoFK', $idInsumoFK)->where('IdPrendaFK', $idPrendaFK)->first();
        return response()->json($insumoPrenda);
    }

    public function update(Request $request, $idInsumoFK, $idPrendaFK)
    {
        try {
            $validatedData = $request->validate([
                'Cantidad' => 'required|integer',
            ]);

            $insumoPrenda = DB::table('insumo_prendas')->where('IdInsumoFK', $idInsumoFK)->where('IdPrendaFK', $idPrendaFK)->update([
                'Cantidad' => $validatedData['Cantidad'],
            ]);

            return response()->json($insumoPrenda);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($idInsumoFK, $idPrendaFK)
    {
        try {
            DB::table('insumo_prendas')->where('IdInsumoFK', $idInsumoFK)->where('IdPrendaFK', $idPrendaFK)->delete();
            return response()->json(['message' => 'InsumoPrenda eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
