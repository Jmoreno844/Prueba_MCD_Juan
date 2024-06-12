<?php

namespace App\Http\Controllers\Api\v1\crud;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $venta = DB::table('venta')->paginate($perPage);
        return response()->json($venta);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Fecha' => 'required|date',
                'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                'IdClienteFK' => 'required|integer|exists:cliente,id',
                'IdFormaPagoFK' => 'required|integer|exists:forma_pago,id',
            ]);

            $venta = DB::table('venta')->insertGetId($validatedData);

            return response()->json(['id' => $venta], 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $venta = DB::table('venta')->where('id', $id)->first();
        return response()->json($venta);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'Fecha' => 'required|date',
                'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                'IdClienteFK' => 'required|integer|exists:cliente,id',
                'IdFormaPagoFK' => 'required|integer|exists:forma_pago,id',
            ]);

            DB::table('venta')->where('id', $id)->update($validatedData);

            return response()->json(['message' => 'Venta actualizada.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('venta')->where('id', $id)->delete();
            return response()->json(['message' => 'Venta eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
