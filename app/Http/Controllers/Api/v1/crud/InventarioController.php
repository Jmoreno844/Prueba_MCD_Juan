<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $inventario = DB::table('inventario')->paginate($perPage);
        return response()->json($inventario);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'CodInv' => 'required|string|max:255',
                'IdPrendaFK' => 'required|integer|exists:prenda,id',
                'IdTallaFK' => 'required|integer|exists:talla,id',
                'IdColorFK' => 'required|integer|exists:color,id',
                'Cantidad' => 'required|integer',
            ]);

            $inventario = DB::table('inventario')->insert([
                'CodInv' => $validatedData['CodInv'],
                'IdPrendaFK' => $validatedData['IdPrendaFK'],
                'IdTallaFK' => $validatedData['IdTallaFK'],
                'IdColorFK' => $validatedData['IdColorFK'],
                'Cantidad' => $validatedData['Cantidad'],
            ]);

            return response()->json($inventario);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $inventario = DB::table('inventario')->where('id', $id)->first();
        return response()->json($inventario);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'CodInv' => 'required|string|max:255',
                'IdPrendaFK' => 'required|integer|exists:prenda,id',
                'IdTallaFK' => 'required|integer|exists:talla,id',
                'IdColorFK' => 'required|integer|exists:color,id',
                'Cantidad' => 'required|integer',
            ]);

            $inventario = DB::table('inventario')->where('id', $id)->update([
                'CodInv' => $validatedData['CodInv'],
                'IdPrendaFK' => $validatedData['IdPrendaFK'],
                'IdTallaFK' => $validatedData['IdTallaFK'],
                'IdColorFK' => $validatedData['IdColorFK'],
                'Cantidad' => $validatedData['Cantidad'],
            ]);

            return response()->json($inventario);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('inventario')->where('id', $id)->delete();
            return response()->json(['message' => 'Inventario eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
