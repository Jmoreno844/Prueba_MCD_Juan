<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MunicipioController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $municipio = DB::table('municipio')->paginate($perPage);
        return response()->json($municipio);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:50',
                'idDepartamentoFK' => 'required|integer|exists:departamento,id',
            ]);

            $municipio = DB::table('municipio')->insert([
                'nombre' => $validatedData['nombre'],
                'idDepartamentoFK' => $validatedData['idDepartamentoFK'],
            ]);

            return response()->json($municipio);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $municipio = DB::table('municipio')->where('id', $id)->first();
        return response()->json($municipio);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:50',
                'idDepartamentoFK' => 'required|integer|exists:departamento,id',
            ]);

            $municipio = DB::table('municipio')->where('id', $id)->update([
                'nombre' => $validatedData['nombre'],
                'idDepartamentoFK' => $validatedData['idDepartamentoFK'],
            ]);

            return response()->json($municipio);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('municipio')->where('id', $id)->delete();
            return response()->json(['message' => 'Municipio eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
