<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaisController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $pais = DB::table('pais')->paginate($perPage);
        return response()->json($pais);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:50',
            ]);

            $pais = DB::table('pais')->insert([
                'nombre' => $validatedData['nombre'],
            ]);

            return response()->json($pais);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $pais = DB::table('pais')->where('id', $id)->first();
        return response()->json($pais);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:50',
            ]);

            $pais = DB::table('pais')->where('id', $id)->update([
                'nombre' => $validatedData['nombre'],
            ]);

            return response()->json($pais);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('pais')->where('id', $id)->delete();
            return response()->json(['message' => 'Pais eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
