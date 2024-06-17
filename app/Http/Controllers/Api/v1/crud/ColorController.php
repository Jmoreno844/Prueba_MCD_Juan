<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\ColorDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\ColorService;

class ColorController extends Controller
{
    protected $colorService;
    protected $fields = ['Descripcion'];

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }


        /**
        *  @OA\Get(
        *     path="/api/color",
        *     tags={"Color"},
        *     summary="Obtener lista de colores",
        *     description="Devuelve una lista paginada de colores",
        *     @OA\Parameter(
        *         name="per_page",
        *         in="query",
        *         description="Número de colores por página",
        *         required=false,
        *         @OA\Schema(
        *             type="integer",
        *             default=15
        *         )
        *     ),
        *     @OA\Response(
        *         response=200,
        *         description="Operación exitosa",
        *         @OA\JsonContent(
        *             type="array",
        *             @OA\Items(
        *                 type="object",
        *                 @OA\Property(property="Descripcion", type="string")
        *             )
        *         )
        *     )
        * )
        */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->colorService->index($perPage);
        return response()->json($items);
    }


     /**
     * @OA\Post(
     *     path="/api/color",
     *     tags={"Color"},
     *     summary="Crear un nuevo color",
     *     description="Crea un nuevo color y lo devuelve",
     *     @OA\RequestBody(
     *         description="Color a crear",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Descripcion", type="string", description="La descripción del color", maxLength=255)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
    */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new ColorDTO($request, $this->fields);
            $this->colorService->store($dto);

            return response()->json(['message' => 'Color creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/color/{id}",
     *     tags={"Color"},
     *     summary="Obtener un color",
     *     description="Devuelve un color específico",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del color a obtener",
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
     *             @OA\Property(property="Descripcion", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Color no encontrado"
     *     )
     * )
     */
    public function show($id)
    {
        $item = $this->colorService->show($id);
        return response()->json($item);
    }


    /**
     * @OA\Put(
     *     path="/api/color/{id}",
     *     tags={"Color"},
     *     summary="Actualizar un color",
     *     description="Actualiza un color existente y lo devuelve",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del color a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Color a actualizar",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Color")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(ref="#/components/schemas/Color")
     *     ),
     *   *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Color no encontrado"
     *     )
     * )
     */

     /**
     * @OA\Put(
     *     path="/api/color/{id}",
     *     tags={"Color"},
     *     summary="Actualizar un color",
     *     description="Actualiza un color existente y lo devuelve",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del color a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Color a actualizar",
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="Descripcion", type="string", description="La descripción del color", maxLength=255)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Color no encontrado"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new ColorDTO($request, $this->fields);
            $this->colorService->update($id, $dto);

            return response()->json(['message' => 'Color actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Delete(
     *     path="/api/color/{id}",
     *     tags={"Color"},
     *     summary="Eliminar un color",
     *     description="Elimina un color existente",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del color a eliminar",
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
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Color no encontrado"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->colorService->destroy($id);

            return response()->json(['message' => 'Color eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
