<?php

use App\Http\Controllers\Api\v1\crud\CargoController;
use App\Http\Controllers\Api\v1\crud\ClienteController;
use App\Http\Controllers\Api\v1\crud\ColorController;
use App\Http\Controllers\Api\v1\crud\DepartamentoController;
use App\Http\Controllers\Api\v1\crud\DetalleOrdenController;
use App\Http\Controllers\Api\v1\crud\DetalleVentaController;
use App\Http\Controllers\Api\v1\crud\EmpleadoController;
use App\Http\Controllers\Api\v1\crud\EmpresaController;
use App\Http\Controllers\Api\v1\crud\EstadoController;
use App\Http\Controllers\Api\v1\crud\FormaPagoController;
use App\Http\Controllers\Api\v1\crud\GeneroController;
use App\Http\Controllers\Api\v1\crud\InsumoController;
use App\Http\Controllers\Api\v1\crud\InsumoPrendasController;
use App\Http\Controllers\Api\v1\crud\InventarioController;
use App\Http\Controllers\Api\v1\crud\MunicipioController;
use App\Http\Controllers\Api\v1\crud\OrdenController;
use App\Http\Controllers\Api\v1\crud\PaisController;
use App\Http\Controllers\Api\v1\crud\PrendaController;
use App\Http\Controllers\Api\v1\crud\UserController;
use App\Http\Controllers\Api\v1\crud\TipoProteccionController;
use App\Http\Controllers\Api\v1\crud\VentaController;
use App\Http\Controllers\Api\v1\crud\ProveedorController;
use App\Http\Controllers\Api\v1\crud\TallaController;
use App\Http\Controllers\Api\v1\crud\TipoEstadoController;
use App\Http\Controllers\Api\v1\crud\TipoPersonaController;
use App\Http\Controllers\Api\v1\crud\InsumoProveedorController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Rutas protegias por JWT
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['json.response', 'auth:api']], function () {
    Route::get("/check", [UserController::class, 'check'])->name("check");

    Route::apiResource('cargos', CargoController::class);
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource("color", ColorController::class);
    Route::apiResource("departamento", DepartamentoController::class );
    Route::apiResource("detalleOrden", DetalleOrdenController::class);
    Route::apiResource("detalleVenta", DetalleVentaController::class);
    Route::apiResource("empleado", EmpleadoController::class);
    Route::apiResource("empresa", EmpresaController::class);
    Route::apiResource("estado", EstadoController::class);
    Route::apiResource("formaPago", FormaPagoController::class);
    Route::apiResource("genero", GeneroController::class);
    Route::apiResource("insumo", InsumoController::class);
    Route::apiResource("insumoPrendas", InsumoPrendasController::class);
    Route::apiResource('insumoProveedor', InsumoProveedorController::class)->except(['update']);
    Route::apiResource("inventario", InventarioController::class);
    Route::apiResource("municipio", MunicipioController::class);
    Route::apiResource("orden", OrdenController::class);
    Route::apiResource("pais", PaisController::class);
    Route::apiResource("prenda", PrendaController::class);
    Route::apiResource("proveedor", ProveedorController::class);
    Route::apiResource("talla", TallaController::class);
    Route::apiResource("tipoEstado", TipoEstadoController::class);
    Route::apiResource("tipoPersona", TipoPersonaController::class);
    Route::apiResource("tipoProteccion", TipoProteccionController::class);
    Route::apiResource("venta", VentaController::class);
});



//Rutas protegias por sesion
Route::group(['middleware' => ['json.response', "auth"]], function () {

});

Route::group(['middleware' => ['json.response']], function () {
    Route::post("/gen_jwt", [UserController::class, 'generateJWT'])->name("gen_jwt");
    Route::post("/register", [UserController::class, 'register'])->name("register");
    Route::post("/login", [UserController::class, 'login'])->name("login");

});
