<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\TipoPersonaDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\TipoPersonaService;

class TipoPersonaController extends Controller
{
    protected $tipoPersonaService;
    protected $fields = ['nombre'];

    public function __construct(TipoPersonaService $tipoPersonaService)
    {
        $this->tipoPersonaService = $tipoPersonaService;
    }

    /**
 * @OA\Get(
 *     path="/api/tipoPersona",
 *     tags={"TipoPersona"},
 *     summary="Obtener lista de tipos de persona",
 *     description="Retorna una lista de tipos de persona",
 *     @OA\Response(
 *         response=200,
 *         description="Operación exitosa",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(property="nombre", type="string", description="Nombre del tipo de persona")
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
        $items = $this->tipoPersonaService->index($perPage);
        return response()->json($items);
    }

    /**
 * @OA\Post(
 *     path="/api/tipoPersona",
 *     tags={"TipoPersona"},
 *     summary="Crear un nuevo tipo de persona",
 *     description="Crea un nuevo tipo de persona con los datos enviados",
 *     @OA\RequestBody(
 *         description="Información del tipo de persona para crear un nuevo item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nombre", type="string", description="Nombre del tipo de persona")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tipo de persona creado correctamente",
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
            $dto = new TipoPersonaDTO($request, $this->fields);
            $this->tipoPersonaService->store($dto);

            return response()->json(['message' => 'TipoPersona creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Get(
 *     path="/api/tipoPersona/{id}",
 *     tags={"TipoPersona"},
 *     summary="Obtener un tipo de persona",
 *     description="Retorna un tipo de persona por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del tipo de persona",
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
 *             @OA\Property(property="nombre", type="string", description="Nombre del tipo de persona")
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
        $item = $this->tipoPersonaService->show($id);
        return response()->json($item);
    }

    /**
 * @OA\Put(
 *     path="/api/tipoPersona/{id}",
 *     tags={"TipoPersona"},
 *     summary="Actualizar un tipo de persona",
 *     description="Actualiza un tipo de persona con los datos enviados",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del tipo de persona a actualizar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\RequestBody(
 *         description="Información del tipo de persona para actualizar un item",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="nombre", type="string", description="Nombre del tipo de persona")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tipo de persona actualizado correctamente",
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
            $dto = new TipoPersonaDTO($request, $this->fields);
            $this->tipoPersonaService->update($id, $dto);

            return response()->json(['message' => 'TipoPersona actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
 * @OA\Delete(
 *     path="/api/tipoPersona/{id}",
 *     tags={"TipoPersona"},
 *     summary="Eliminar un tipo de persona",
 *     description="Elimina un tipo de persona por su ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID del tipo de persona a eliminar",
 *         required=true,
 *         @OA\Schema(
 *             type="integer"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Tipo de persona eliminado correctamente",
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
            $this->tipoPersonaService->destroy($id);

            return response()->json(['message' => 'TipoPersona eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
