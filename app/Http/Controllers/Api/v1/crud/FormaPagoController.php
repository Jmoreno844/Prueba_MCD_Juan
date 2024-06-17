<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\FormaPagoDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\FormaPagoService;

class FormaPagoController extends Controller
{
    protected $formaPagoService;
    protected $fields = ['Descripcion'];

    public function __construct(FormaPagoService $formaPagoService)
    {
        $this->formaPagoService = $formaPagoService;
    }

     /**
     * @OA\Get(
     *     path="/api/formaPago",
     *     tags={"FormaPago"},
     *     summary="Obtener todas las formas de pago",
     *     description="Retorna una lista de formas de pago",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->formaPagoService->index($perPage);
        return response()->json($items);
    }

     /**
     * @OA\Post(
     *     path="/api/formaPago",
     *     tags={"FormaPago"},
     *     summary="Crear una nueva forma de pago",
     *     description="Crea una nueva forma de pago y la retorna",
     *     @OA\RequestBody(
     *         description="Forma de pago a crear",
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
     *         description="Forma de pago creada correctamente"
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
            $dto = new FormaPagoDTO($request, $this->fields);
            $this->formaPagoService->store($dto);

            return response()->json(['message' => 'FormaPago creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

        /**
     * @OA\Get(
     *     path="/api/formaPago/{id}",
     *     tags={"FormaPago"},
     *     summary="Obtener una forma de pago por ID",
     *     description="Retorna una forma de pago por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la forma de pago a obtener",
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
        $item = $this->formaPagoService->show($id);
        return response()->json($item);
    }

      /**
     * @OA\Put(
     *     path="/api/formaPago/{id}",
     *     tags={"FormaPago"},
     *     summary="Actualizar una forma de pago por ID",
     *     description="Actualiza una forma de pago por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la forma de pago a actualizar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Forma de pago a actualizar",
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
     *         description="Forma de pago actualizada correctamente"
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
            $dto = new FormaPagoDTO($request, $this->fields);
            $this->formaPagoService->update($id, $dto);

            return response()->json(['message' => 'FormaPago actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/formaPago/{id}",
     *     tags={"FormaPago"},
     *     summary="Eliminar una forma de pago por ID",
     *     description="Elimina una forma de pago por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la forma de pago a eliminar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Forma de pago eliminada correctamente"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $this->formaPagoService->destroy($id);

            return response()->json(['message' => 'FormaPago eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
