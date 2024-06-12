<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TallaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $talla = DB::table('talla')->paginate($perPage);
        return response()->json($talla);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|string|max:50',
            ]);

            $talla = DB::table('talla')->insertGetId($validatedData);

            return response()->json(['id' => $talla], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $talla = DB::table('talla')->where('id', $id)->first();
        return response()->json($talla);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|string|max:50',
            ]);

            DB::table('talla')->where('id', $id)->update($validatedData);

            return response()->json(['message' => 'Talla actualizada.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('talla')->where('id', $id)->delete();
            return response()->json(['message' => 'Talla eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
