<?php

namespace App\Http\Controllers\Api\v1\crud;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $colores = DB::table('color')->paginate($perPage);
        return response()->json($colores);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|max:255',
            ]);

            $color = DB::table('color')->insert([
                'Descripcion' => $validatedData['Descripcion'],
            ]);

            return response()->json($color);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $color = DB::table('color')->where('id', $id)->first();
        return response()->json($color);
    }


public function update(Request $request, $id)
{
    try {
        $validatedData = $request->validate([
            'Descripcion' => 'required|max:255',
        ]);

        $color = DB::table('color')->where('id', $id)->update([
            'Descripcion' => $validatedData['Descripcion'],
        ]);

        return response()->json($color);
    } catch (ValidationException $e) {
        return response()->json(['message' => $e->errors()], 422);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}

public function destroy($id)
{
    try {
        DB::table('color')->where('id', $id)->delete();
        return response()->json(['message' => 'Color eliminado.']);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
}
}
