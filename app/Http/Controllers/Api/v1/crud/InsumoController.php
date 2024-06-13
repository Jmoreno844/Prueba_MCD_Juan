<?php

namespace App\Http\Controllers\Api\v1\crud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Validation\ValidationException;

class InsumoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $insumos = DB::table('insumo')->paginate($perPage);
        return response()->json($insumos);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|max:50',
                'valor_unit' => 'required|numeric',
                'stock_min' => 'required|numeric',
                'stock_max' => 'required|numeric',
            ]);

            $insumo = DB::table('insumo')->insert([
                'nombre' => $validatedData['nombre'],
                'valor_unit' => $validatedData['valor_unit'],
                'stock_min' => $validatedData['stock_min'],
                'stock_max' => $validatedData['stock_max'],
            ]);

            return response()->json($insumo);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $insumo = DB::table('insumo')->where('id', $id)->first();
        return response()->json($insumo);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|max:50',
                'valor_unit' => 'required|numeric',
                'stock_min' => 'required|numeric',
                'stock_max' => 'required|numeric',
            ]);

            $insumo = DB::table('insumo')->where('id', $id)->update([
                'nombre' => $validatedData['nombre'],
                'valor_unit' => $validatedData['valor_unit'],
                'stock_min' => $validatedData['stock_min'],
                'stock_max' => $validatedData['stock_max'],
            ]);

            return response()->json($insumo);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('insumo')->where('id', $id)->delete();
            return response()->json(['message' => 'Insumo eliminado']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
