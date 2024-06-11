<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GeneroController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $generos = DB::table('genero')->paginate($perPage);
        return response()->json($generos);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'descripcion' => 'required|max:50',
            ]);

            $genero = DB::table('genero')->insert([
                'descripcion' => $validatedData['descripcion'],
            ]);

            return response()->json($genero);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $genero = DB::table('genero')->where('id', $id)->first();
        return response()->json($genero);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'descripcion' => 'required|max:50',
            ]);

            $genero = DB::table('genero')->where('id', $id)->update([
                'descripcion' => $validatedData['descripcion'],
            ]);

            return response()->json($genero);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('genero')->where('id', $id)->delete();
            return response()->json(['message' => 'Genero eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
