<?php

namespace App\Http\Controllers\Api\v1\crud;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DetalleOrdenController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $detalle_ordenes = DB::table('detalle_orden')->paginate($perPage);
        return response()->json($detalle_ordenes);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'IdOrdenFk' => 'required|integer',
                'IdPrendaFk' => 'required|integer',
                'IdColorFK' => 'required|integer',
                'IdTallaFK' => 'required|integer',
                'PrendaId' => 'required|integer',
                'cantidad_producir' => 'required|integer',
                'cantidad_producida' => 'required|integer',
                'IdEstadoFk' => 'required|integer',
            ]);

            $detalle_orden = DB::table('detalle_orden')->insert([
                'IdOrdenFk' => $validatedData['IdOrdenFk'],
                'IdPrendaFk' => $validatedData['IdPrendaFk'],
                'IdColorFK' => $validatedData['IdColorFK'],
                'IdTallaFK' => $validatedData['IdTallaFK'],
                'PrendaId' => $validatedData['PrendaId'],
                'cantidad_producir' => $validatedData['cantidad_producir'],
                'cantidad_producida' => $validatedData['cantidad_producida'],
                'IdEstadoFk' => $validatedData['IdEstadoFk'],
            ]);

            return response()->json($detalle_orden);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $detalle_orden = DB::table('detalle_orden')->where('id', $id)->first();
        return response()->json($detalle_orden);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'IdOrdenFk' => 'required|integer',
                'IdPrendaFk' => 'required|integer',
                'IdColorFK' => 'required|integer',
                'IdTallaFK' => 'required|integer',
                'PrendaId' => 'required|integer',
                'cantidad_producir' => 'required|integer',
                'cantidad_producida' => 'required|integer',
                'IdEstadoFk' => 'required|integer',
            ]);

            $detalle_orden = DB::table('detalle_orden')->where('id', $id)->update([
                'IdOrdenFk' => $validatedData['IdOrdenFk'],
                'IdPrendaFk' => $validatedData['IdPrendaFk'],
                'IdColorFK' => $validatedData['IdColorFK'],
                'IdTallaFK' => $validatedData['IdTallaFK'],
                'PrendaId' => $validatedData['PrendaId'],
                'cantidad_producir' => $validatedData['cantidad_producir'],
                'cantidad_producida' => $validatedData['cantidad_producida'],
                'IdEstadoFk' => $validatedData['IdEstadoFk'],
            ]);

            return response()->json($detalle_orden);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('detalle_orden')->where('id', $id)->delete();
            return response()->json(['message' => 'Detalle_Orden eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
