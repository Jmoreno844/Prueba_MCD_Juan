<?php

namespace App\Http\Controllers\Api\v1\crud;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $empleados = DB::table('empleado')->paginate($perPage);
        return response()->json($empleados);
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|max:50',
                'idCargoFK' => 'required|integer',
                'fecha_ingreso' => 'required|date',
                'IdMunicipioFK' => 'required|integer',
            ]);

            $empleado = DB::table('empleado')->insert([
                'nombre' => $validatedData['nombre'],
                'idCargoFK' => $validatedData['idCargoFK'],
                'fecha_ingreso' => $validatedData['fecha_ingreso'],
                'IdMunicipioFK' => $validatedData['IdMunicipioFK'],
            ]);

            return response()->json($empleado);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $empleado = DB::table('empleado')->where('id', $id)->first();
        return response()->json($empleado);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|max:50',
                'idCargoFK' => 'required|integer',
                'fecha_ingreso' => 'required|date',
                'IdMunicipioFK' => 'required|integer',
            ]);

            $empleado = DB::table('empleado')->where('id', $id)->update([
                'nombre' => $validatedData['nombre'],
                'idCargoFK' => $validatedData['idCargoFK'],
                'fecha_ingreso' => $validatedData['fecha_ingreso'],
                'IdMunicipioFK' => $validatedData['IdMunicipioFK'],
            ]);

            return response()->json($empleado);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('empleado')->where('id', $id)->delete();
            return response()->json(['message' => 'Empleado eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
