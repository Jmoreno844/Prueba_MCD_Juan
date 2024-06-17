<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\PaisDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\PaisService;

class PaisController extends Controller
{
    protected $paisService;
    protected $fields = ['nombre'];

    public function __construct(PaisService $paisService)
    {
        $this->paisService = $paisService;
    }

    /**
 * @OA\Get(
 *     path="/api/pais",
 *     tags={"Pais"},
 *     summary="Obtener lista de países",
 *     description="Retorna una lista de países",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="nombre", type="string", description="Nombre del país")
 *             )
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->paisService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/pais",
 *     tags={"Pais"},
 *     summary="Crear un nuevo país",
 *     description="Crea un nuevo país con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información del país para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nombre", type="string", description="Nombre del país")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="País creado correctamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new PaisDTO($request, $this->fields);
            $this->paisService->store($dto);

            return response()->json(['message' => 'Pais creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/pais/{id}",
 *     tags={"Pais"},
 *     summary="Obtener un país",
 *     description="Retorna un país por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del país",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="nombre", type="string", description="Nombre del país")
 *         ),
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function show($id)
    {
        $item = $this->paisService->show($id);
        return response()->json($item);
    }

    /**
 * @OA\Put(
 *     path="/api/pais/{id}",
 *     tags={"Pais"},
 *     summary="Actualizar un país",
 *     description="Actualiza un país con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del país a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información del país para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nombre", type="string", description="Nombre del país")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="País actualizado correctamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new PaisDTO($request, $this->fields);
            $this->paisService->update($id, $dto);

            return response()->json(['message' => 'Pais actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/pais/{id}",
 *     tags={"Pais"},
 *     summary="Eliminar un país",
 *     description="Elimina un país por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del país a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="País eliminado correctamente",
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="Ha ocurrido un error",
 *     )
 * )
 */
    public function destroy($id)
    {
        try {
            $this->paisService->destroy($id);

            return response()->json(['message' => 'Pais eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
