<?php

namespace App\Http\Controllers\Api\v1\crud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Validation\ValidationException;

class FormaPagoController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15); // Default to 15 items per page if not set
        $forma_pagos = DB::table('forma_pago')->paginate($perPage);
        return response()->json($forma_pagos);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|max:50',
            ]);

            $forma_pago = DB::table('forma_pago')->insert([
                'Descripcion' => $validatedData['Descripcion'],
            ]);

            return response()->json($forma_pago);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $forma_pago = DB::table('forma_pago')->where('id', $id)->first();
        return response()->json($forma_pago);
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'Descripcion' => 'required|max:50',
            ]);

            $forma_pago = DB::table('forma_pago')->where('id', $id)->update([
                'Descripcion' => $validatedData['Descripcion'],
            ]);

            return response()->json($forma_pago);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::table('forma_pago')->where('id', $id)->delete();
            return response()->json(['message' => 'Forma Pago eliminada.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
