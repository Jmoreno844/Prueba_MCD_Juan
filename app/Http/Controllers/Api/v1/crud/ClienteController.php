<?php

namespace App\Http\Controllers\Api\v1\crud;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $clientes = DB::table('clientes')->paginate($perPage);
        return response()->json($clientes);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|max:50',
                'IdCliente' => 'required|max:50',
                'IdTipoPersonaFK' => 'required|integer',
                'fechaRegistro' => 'required|date',
                'IdMunicipioFK' => 'required|integer',
            ]);

            $cliente = DB::table('clientes')->insert([
                'nombre' => $validatedData['nombre'],
                'IdCliente' => $validatedData['IdCliente'],
                'IdTipoPersonaFK' => $validatedData['IdTipoPersonaFK'],
                'fechaRegistro' => $validatedData['fechaRegistro'],
                'IdMunicipioFK' => $validatedData['IdMunicipioFK'],
            ]);

            return response()->json($cliente);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $cliente = DB::table('clientes')->where('id', $id)->first();
        return response()->json($cliente);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|max:50',
                'IdCliente' => 'required|max:50',
                'IdTipoPersonaFK' => 'required|integer',
                'fechaRegistro' => 'required|date',
                'IdMunicipioFK' => 'required|integer',
            ]);

            $cliente = DB::table('clientes')->where('id', $id)->update([
                'nombre' => $validatedData['nombre'],
                'IdCliente' => $validatedData['IdCliente'],
                'IdTipoPersonaFK' => $validatedData['IdTipoPersonaFK'],
                'fechaRegistro' => $validatedData['fechaRegistro'],
                'IdMunicipioFK' => $validatedData['IdMunicipioFK'],
            ]);

            return response()->json($cliente);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('clientes')->where('id', $id)->delete();
            return response()->json(['message' => 'Cliente eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
