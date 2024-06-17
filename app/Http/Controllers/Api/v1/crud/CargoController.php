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
/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="support@my-api.com",
 *         name="Support Team"
 *     )
 * )
 */


    protected $fields = ['descripcion', 'sueldo_base'];

    protected $cargoService;

    public function __construct(CargoService $cargoService)
    {
        $this->cargoService = $cargoService;
    }

    /**
 * @OA\Get(
 *     tags={"Cargos"},
 *     path="/api/cargos",
 *     summary="Obtener lista de cargos",
 *     @OA\Response(
 *         response=200,
 *         description="Lista de cargos"
 *     )
 * )
 */


    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $cargos = $this->cargoService->index($perPage);
        return response()->json($cargos);
    }

    /**
 * @OA\Post(
 *     tags={"Cargos"},
 *     path="/api/cargos",
 *     summary="Crear un nuevo cargo",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="descripcion",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="sueldo_base",
 *                     type="number"
 *                 ),
 *                 example={"descripcion": "Gerente", "sueldo_base": 5000}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cargo creado correctamente."
 *     )
 * )
 */

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

    /**
 * @OA\Get(
 *     tags={"Cargos"},
 *     path="/api/cargos/{id}",
 *     summary="Obtener un cargo específico",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del cargo a obtener",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cargo obtenido correctamente."
 *     )
 * )
 */
    public function show($id)
    {
        $cargo = $this->cargoService->show($id);
        return response()->json($cargo);
    }



/**
 * @OA\Put(
 *     tags={"Cargos"},
 *     path="/api/cargos/{id}",
 *     summary="Actualizar un cargo específico",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del cargo a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="descripcion",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="sueldo_base",
 *                     type="number"
 *                 ),
 *                 example={"descripcion": "Gerente", "sueldo_base": 5000}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cargo actualizado correctamente."
 *     )
 * )
 */
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


/**
 * @OA\Delete(
 *     tags={"Cargos"},
 *     path="/api/cargos/{id}",
 *     summary="Eliminar un cargo específico",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del cargo a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Cargo eliminado correctamente."
 *     )
 * )
 */
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
