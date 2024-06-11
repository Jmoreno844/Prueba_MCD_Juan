<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrdenController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $orden = DB::table('orden')->paginate($perPage);
        return response()->json($orden);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'fecha' => 'required|date',
                'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                'IdClienteFK' => 'required|integer|exists:cliente,id',
                'IdEstadoFK' => 'required|integer|exists:estado,id',
            ]);

            $orden = DB::table('orden')->insert([
                'fecha' => $validatedData['fecha'],
                'IdEmpleadoFK' => $validatedData['IdEmpleadoFK'],
                'IdClienteFK' => $validatedData['IdClienteFK'],
                'IdEstadoFK' => $validatedData['IdEstadoFK'],
            ]);

            return response()->json($orden);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $orden = DB::table('orden')->where('id', $id)->first();
        return response()->json($orden);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'fecha' => 'required|date',
                'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                'IdClienteFK' => 'required|integer|exists:cliente,id',
                'IdEstadoFK' => 'required|integer|exists:estado,id',
            ]);

            $orden = DB::table('orden')->where('id', $id)->update([
                'fecha' => $validatedData['fecha'],
                'IdEmpleadoFK' => $validatedData['IdEmpleadoFK'],
                'IdClienteFK' => $validatedData['IdClienteFK'],
                'IdEstadoFK' => $validatedData['IdEstadoFK'],
            ]);

            return response()->json($orden);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('orden')->where('id', $id)->delete();
            return response()->json(['message' => 'Orden eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
