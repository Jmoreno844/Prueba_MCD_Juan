<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EstadoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $estados = DB::table('estado')->paginate($perPage);
        return response()->json($estados);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|max:50',
                'IdTipoEstadoFK' => 'required|integer',
            ]);

            $estado = DB::table('estado')->insert([
                'Descripcion' => $validatedData['Descripcion'],
                'IdTipoEstadoFK' => $validatedData['IdTipoEstadoFK'],
            ]);

            return response()->json($estado);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $estado = DB::table('estado')->where('id', $id)->first();
        return response()->json($estado);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|max:50',
                'IdTipoEstadoFK' => 'required|integer',
            ]);

            $estado = DB::table('estado')->where('id', $id)->update([
                'Descripcion' => $validatedData['Descripcion'],
                'IdTipoEstadoFK' => $validatedData['IdTipoEstadoFK'],
            ]);

            return response()->json($estado);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('estado')->where('id', $id)->delete();
            return response()->json(['message' => 'Estado eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
