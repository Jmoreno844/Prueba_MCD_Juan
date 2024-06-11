<?php

namespace App\Http\Controllers\Api\v1\crud;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DepartamentoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $departamentos = DB::table('departamento')->paginate($perPage);
        return response()->json($departamentos);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|max:50',
                'IdPaisFK' => 'required|integer',
            ]);

            $departamento = DB::table('departamento')->insert([
                'nombre' => $validatedData['nombre'],
                'IdPaisFK' => $validatedData['IdPaisFK'],
            ]);

            return response()->json($departamento);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $departamento = DB::table('departamento')->where('id', $id)->first();
        return response()->json($departamento);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|max:50',
                'IdPaisFK' => 'required|integer',
            ]);

            $departamento = DB::table('departamento')->where('id', $id)->update([
                'nombre' => $validatedData['nombre'],
                'IdPaisFK' => $validatedData['IdPaisFK'],
            ]);

            return response()->json($departamento);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('departamento')->where('id', $id)->delete();
            return response()->json(['message' => 'Departamento eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
