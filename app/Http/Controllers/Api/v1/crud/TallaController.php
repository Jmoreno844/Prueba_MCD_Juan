<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\TallaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\TallaService;

class TallaController extends Controller
{
    protected $tallaService;
    protected $fields = ['Descripcion'];

    public function __construct(TallaService $tallaService)
    {
        $this->tallaService = $tallaService;
    }

    /**
 * @OA\Get(
 *     path="/api/talla",
 *     tags={"Talla"},
 *     summary="Obtener lista de tallas",
 *     description="Retorna una lista de tallas",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="Descripcion", type="string", description="Descripción de la talla")
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
        $items = $this->tallaService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/talla",
 *     tags={"Talla"},
 *     summary="Crear una nueva talla",
 *     description="Crea una nueva talla con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información de la talla para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Descripcion", type="string", description="Descripción de la talla")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Talla creada correctamente",
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
            'Descripcion' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new TallaDTO($request, $this->fields);
            $this->tallaService->store($dto);

            return response()->json(['message' => 'Talla creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/talla/{id}",
 *     tags={"Talla"},
 *     summary="Obtener una talla",
 *     description="Retorna una talla por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la talla",
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
 *             @OA\Property(property="Descripcion", type="string", description="Descripción de la talla")
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
        $item = $this->tallaService->show($id);
        return response()->json($item);
    }

    /**
 * @OA\Put(
 *     path="/api/talla/{id}",
 *     tags={"Talla"},
 *     summary="Actualizar una talla",
 *     description="Actualiza una talla con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la talla a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información de la talla para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="Descripcion", type="string", description="Descripción de la talla")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Talla actualizada correctamente",
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
            'Descripcion' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new TallaDTO($request, $this->fields);
            $this->tallaService->update($id, $dto);

            return response()->json(['message' => 'Talla actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/talla/{id}",
 *     tags={"Talla"},
 *     summary="Eliminar una talla",
 *     description="Elimina una talla por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID de la talla a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Talla eliminada correctamente",
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
            $this->tallaService->destroy($id);

            return response()->json(['message' => 'Talla eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
