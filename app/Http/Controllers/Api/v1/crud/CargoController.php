<?php

namespace App\Http\Controllers\Api\v1\crud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Validation\ValidationException;

class CargoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $cargos = DB::table('cargos')->paginate($perPage);
        return response()->json($cargos);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'descripcion' => 'required|max:50',
                'sueldo_base' => 'required|numeric',
            ]);

            $cargo = DB::table('cargos')->insert([
                'descripcion' => $validatedData['descripcion'],
                'sueldo_base' => $validatedData['sueldo_base'],
            ]);

            return response()->json($cargo);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $cargo = DB::table('cargos')->where('id', $id)->first();
        return response()->json($cargo);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'descripcion' => 'required|max:50',
                'sueldo_base' => 'required|numeric',
            ]);

            $cargo = DB::table('cargos')->where('id', $id)->update([
                'descripcion' => $validatedData['descripcion'],
                'sueldo_base' => $validatedData['sueldo_base'],
            ]);

            return response()->json($cargo);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('cargos')->where('id', $id)->delete();
            return response()->json(['message' => 'Cargo eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
