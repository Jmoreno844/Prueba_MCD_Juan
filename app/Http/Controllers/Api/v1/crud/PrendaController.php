<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PrendaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $prenda = DB::table('prenda')->paginate($perPage);
        return response()->json($prenda);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Nombre' => 'required|string|max:50',
                'ValorUnitCop' => 'required|numeric',
                'ValorUnitUsd' => 'required|numeric',
                'IdEstadoFK' => 'required|integer|exists:estado,id',
                'IdTipoProteccionFK' => 'required|integer|exists:tipo_proteccion,id',
                'IdGeneroFK' => 'required|integer|exists:genero,id',
                'Codigo' => 'required|string|max:50',
            ]);

            $prenda = DB::table('prenda')->insertGetId($validatedData);

            return response()->json(['id' => $prenda], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $prenda = DB::table('prenda')->where('id', $id)->first();
        return response()->json($prenda);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'Nombre' => 'required|string|max:50',
                'ValorUnitCop' => 'required|numeric',
                'ValorUnitUsd' => 'required|numeric',
                'IdEstadoFK' => 'required|integer|exists:estado,id',
                'IdTipoProteccionFK' => 'required|integer|exists:tipo_proteccion,id',
                'IdGeneroFK' => 'required|integer|exists:genero,id',
                'Codigo' => 'required|string|max:50',
            ]);

            DB::table('prenda')->where('id', $id)->update($validatedData);

            return response()->json(['message' => 'Prenda updated successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('prenda')->where('id', $id)->delete();
            return response()->json(['message' => 'Prenda eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
