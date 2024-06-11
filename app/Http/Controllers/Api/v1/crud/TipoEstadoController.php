<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TipoEstadoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $tipoEstado = DB::table('tipo_estado')->paginate($perPage);
        return response()->json($tipoEstado);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|string|max:50',
            ]);

            $tipoEstado = DB::table('tipo_estado')->insertGetId($validatedData);

            return response()->json(['id' => $tipoEstado], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $tipoEstado = DB::table('tipo_estado')->where('id', $id)->first();
        return response()->json($tipoEstado);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|string|max:50',
            ]);

            DB::table('tipo_estado')->where('id', $id)->update($validatedData);

            return response()->json(['message' => 'TipoEstado actualizado.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('tipo_estado')->where('id', $id)->delete();
            return response()->json(['message' => 'TipoEstado eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
