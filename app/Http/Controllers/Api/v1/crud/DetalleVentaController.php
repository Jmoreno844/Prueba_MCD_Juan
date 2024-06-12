<?php

namespace App\Http\Controllers\Api\v1\crud;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DetalleVentaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $detalle_ventas = DB::table('detalle_venta')->paginate($perPage);
        return response()->json($detalle_ventas);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'IdVentaFK' => 'required|integer',
                'IdInventarioFK' => 'required|integer',
                'Cantidad' => 'required|integer',
            ]);

            $detalle_venta = DB::table('detalle_venta')->insert([
                'IdVentaFK' => $validatedData['IdVentaFK'],
                'IdInventarioFK' => $validatedData['IdInventarioFK'],
                'Cantidad' => $validatedData['Cantidad'],
            ]);

            return response()->json($detalle_venta);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $detalle_venta = DB::table('detalle_venta')->where('id', $id)->first();
        return response()->json($detalle_venta);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'IdVentaFK' => 'required|integer',
                'IdInventarioFK' => 'required|integer',
                'Cantidad' => 'required|integer',
            ]);

            $detalle_venta = DB::table('detalle_venta')->where('id', $id)->update([
                'IdVentaFK' => $validatedData['IdVentaFK'],
                'IdInventarioFK' => $validatedData['IdInventarioFK'],
                'Cantidad' => $validatedData['Cantidad'],
            ]);

            return response()->json($detalle_venta);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('detalle_venta')->where('id', $id)->delete();
            return response()->json(['message' => 'Detalle_Venta eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
