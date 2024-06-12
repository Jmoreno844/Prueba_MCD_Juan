<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TipoPersonaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $tipoPersona = DB::table('tipo_persona')->paginate($perPage);
        return response()->json($tipoPersona);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:50',
            ]);

            $tipoPersona = DB::table('tipo_persona')->insertGetId($validatedData);

            return response()->json(['id' => $tipoPersona], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $tipoPersona = DB::table('tipo_persona')->where('id', $id)->first();
        return response()->json($tipoPersona);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:50',
            ]);

            DB::table('tipo_persona')->where('id', $id)->update($validatedData);

            return response()->json(['message' => 'TipoPersona actualizada.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('tipo_persona')->where('id', $id)->delete();
            return response()->json(['message' => 'TipoPersona eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
