<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $empresas = DB::table('empresa')->paginate($perPage);
        return response()->json($empresas);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nit' => 'required|max:50',
                'razon_social' => 'required',
                'representante_legal' => 'required|max:50',
                'FechaCreacion' => 'required|date',
                'IdMunicipioFK' => 'required|integer',
            ]);

            $empresa = DB::table('empresa')->insert([
                'nit' => $validatedData['nit'],
                'razon_social' => $validatedData['razon_social'],
                'representante_legal' => $validatedData['representante_legal'],
                'FechaCreacion' => $validatedData['FechaCreacion'],
                'IdMunicipioFK' => $validatedData['IdMunicipioFK'],
            ]);

            return response()->json($empresa);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $empresa = DB::table('empresa')->where('id', $id)->first();
        return response()->json($empresa);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nit' => 'required|max:50',
                'razon_social' => 'required',
                'representante_legal' => 'required|max:50',
                'FechaCreacion' => 'required|date',
                'IdMunicipioFK' => 'required|integer',
            ]);

            $empresa = DB::table('empresa')->where('id', $id)->update([
                'nit' => $validatedData['nit'],
                'razon_social' => $validatedData['razon_social'],
                'representante_legal' => $validatedData['representante_legal'],
                'FechaCreacion' => $validatedData['FechaCreacion'],
                'IdMunicipioFK' => $validatedData['IdMunicipioFK'],
            ]);

            return response()->json($empresa);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('empresa')->where('id', $id)->delete();
            return response()->json(['message' => 'Empresa eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
