<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\EstadoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\EstadoService;

class EstadoController extends Controller
{
    protected $estadoService;
    protected $fields = ['Descripcion'];

    public function __construct(EstadoService $estadoService)
    {
        $this->estadoService = $estadoService;
    }

      /**
     * @OA\Get(
     *     path="/api/estado",
     *     tags={"Estado"},
     *     summary="Obtener todos los estados",
     *     description="Retorna una lista de estados",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->estadoService->index($perPage);
        return response()->json($items);
    }

     /**
     * @OA\Post(
     *     path="/api/estado",
     *     tags={"Estado"},
     *     summary="Crear un nuevo estado",
     *     description="Crea un nuevo estado y lo retorna",
     *     @OA\RequestBody(
     *         description="Estado a crear",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="Descripcion",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado creado correctamente"
     *     ),
      *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EstadoDTO($request, $this->fields);
            $this->estadoService->store($dto);

            return response()->json(['message' => 'Estado creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

     /**
     * @OA\Get(
     *     path="/api/estado/{id}",
     *     tags={"Estado"},
     *     summary="Obtener un estado por ID",
     *     description="Retorna un estado por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estado a obtener",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     )
     * )
     */
    public function show($id)
    {
        $item = $this->estadoService->show($id);
        return response()->json($item);
    }

     /**
     * @OA\Put(
     *     path="/api/estado/{id}",
     *     tags={"Estado"},
     *     summary="Actualizar un estado por ID",
     *     description="Actualiza un estado por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estado a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Estado a actualizar",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="Descripcion",
     *                     type="string"
     *                 )
       *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado actualizado correctamente"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de entrada no válidos"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Descripcion' => 'required|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new EstadoDTO($request, $this->fields);
            $this->estadoService->update($id, $dto);

            return response()->json(['message' => 'Estado actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/estado/{id}",
     *     tags={"Estado"},
     *     summary="Eliminar un estado por ID",
     *     description="Elimina un estado por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del estado a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Estado eliminado correctamente"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->estadoService->destroy($id);

            return response()->json(['message' => 'Estado eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
