<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TipoProteccionController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $tipoProteccion = DB::table('tipo_proteccion')->paginate($perPage);
        return response()->json($tipoProteccion);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|string|max:50',
            ]);

            $tipoProteccion = DB::table('tipo_proteccion')->insertGetId($validatedData);

            return response()->json(['id' => $tipoProteccion], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $tipoProteccion = DB::table('tipo_proteccion')->where('id', $id)->first();
        return response()->json($tipoProteccion);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|string|max:50',
            ]);

            DB::table('tipo_proteccion')->where('id', $id)->update($validatedData);

            return response()->json(['message' => 'TipoProteccion actualizada.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('tipo_proteccion')->where('id', $id)->delete();
            return response()->json(['message' => 'TipoProteccion eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
