<?php

namespace App\Http\Controllers\Api\v1\crud;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\CargoService;
use App\DTOs\CargoDTO;
class CargoController extends Controller
{
    protected $fields = ['descripcion', 'sueldo_base'];

    protected $cargoService;

    public function __construct(CargoService $cargoService)
    {
        $this->cargoService = $cargoService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $cargos = $this->cargoService->index($perPage);
        return response()->json($cargos);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'descripcion' => 'required|max:50',
            'sueldo_base' => 'required|numeric',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->errors()], 422);
        }

        try {
            $cargoDTO = new CargoDTO($request, $this->fields);

            $this->cargoService->store($cargoDTO);

            return response()->json(['message' => 'Cargo creado correctamente.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $cargo = $this->cargoService->show($id);
        return response()->json($cargo);
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'descripcion' => 'required|max:50',
            'sueldo_base' => 'required|numeric',
        ]);
        if ($validatedData->fails()) {
            return response()->json(['message' => $validatedData->errors()], 422);
        }

        try {
            $cargoDTO = new CargoDTO($request, $this->fields);


            $this->cargoService->update($id, $cargoDTO);

            return response()->json(['message' => 'Cargo actualizado correctamente.']);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->cargoService->destroy($id);
            return response()->json(['message' => 'Cargo eliminado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
