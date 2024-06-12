<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $proveedor = DB::table('proveedor')->paginate($perPage);
        return response()->json($proveedor);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'NitProovedor' => 'required|string|max:50',
                'Nombre' => 'required|string|max:50',
                'IdTipoPersona' => 'required|integer|exists:tipo_persona,id',
                'IdMunicipioFK' => 'required|integer|exists:municipio,id',
            ]);

            $proveedor = DB::table('proveedor')->insertGetId($validatedData);

            return response()->json(['id' => $proveedor], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $proveedor = DB::table('proveedor')->where('id', $id)->first();
        return response()->json($proveedor);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'NitProovedor' => 'required|string|max:50',
                'Nombre' => 'required|string|max:50',
                'IdTipoPersona' => 'required|integer|exists:tipo_persona,id',
                'IdMunicipioFK' => 'required|integer|exists:municipio,id',
            ]);

            DB::table('proveedor')->where('id', $id)->update($validatedData);

            return response()->json(['message' => 'Proveedor updated successfully.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('proveedor')->where('id', $id)->delete();
            return response()->json(['message' => 'Proveedor eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
