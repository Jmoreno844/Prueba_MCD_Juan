<?php
namespace App\Http\Controllers\Api\v1\crud;

use App\DTOs\InsumoProveedorDTO;
use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\InsumoProveedorService;

class InsumoProveedorController extends Controller
{
    protected $insumoproveedorService;
    protected $fields = ['IdInsumoFK', 'IdProveedorFK'];

    public function __construct(InsumoProveedorService $insumoproveedorService)
    {
        $this->insumoproveedorService = $insumoproveedorService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        $items = $this->insumoproveedorService->index($perPage);
        return response()->json($items);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'IdInsumoFK' => 'required|integer',
                    'IdProveedorFK' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InsumoProveedorDTO($request, $this->fields);
            $this->insumoproveedorService->store($dto);

            return response()->json(['message' => 'InsumoProveedor creado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $item = $this->insumoproveedorService->show($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'IdInsumoFK' => 'required|integer',
                    'IdProveedorFK' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        try {
            $dto = new InsumoProveedorDTO($request, $this->fields);
            $this->insumoproveedorService->update($id, $dto);

            return response()->json(['message' => 'InsumoProveedor actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->insumoproveedorService->destroy($id);

            return response()->json(['message' => 'InsumoProveedor eliminado.']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}