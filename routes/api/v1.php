<?php

use App\Http\Controllers\Api\v1\ConsultasController;
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


//"auth:api"
Route::group(['middleware' => ['json.response']], function () {
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
    Route::apiResource('insumoProveedor', InsumoProveedorController::class)->except(['update']);
    Route::apiResource("inventario", InventarioController::class);
    Route::apiResource("municipio", MunicipioController::class);
    Route::apiResource("orden", OrdenController::class);
    Route::apiResource("pais", PaisController::class);
    Route::apiResource("prenda", PrendaController::class);
    Route::apiResource("proveedor", ProveedorController::class);
    Route::apiResource("talla", TallaController::class);
    Route::apiResource("tipoPersona", TipoPersonaController::class);
    Route::apiResource("tipoProteccion", TipoProteccionController::class);

    Route::apiResource("venta", VentaController::class);
    Route::get('insumoPrendas', [InsumoPrendasController::class , "index"])->name('insumoPrendas.index');
    Route::post('insumoPrendas/{idInsumoFK}/{idPrendaFK}', [InsumoPrendasController::class , "store"])->name('insumoPrendas.store');
    Route::get('insumoPrendas/{idInsumoFK}/{idPrendaFK}', [InsumoPrendasController::class,'show'])->name('insumoPrendas.show');
    Route::put('insumoPrendas/{idInsumoFK}/{idPrendaFK}', [InsumoPrendasController::class , "update"])->name('insumoPrendas.update');
    Route::delete('insumoPrendas/{idInsumoFK}/{idPrendaFK}', [InsumoPrendasController::class,'destroy'])->name('insumoPrendas.destroy');

    Route::get('insumoProveedor', [InsumoProveedorController::class , "index"])->name('insumoProveedor.index');
    Route::post('insumoProveedor/{idInsumoFK}/{idProveedorFK}', [InsumoProveedorController::class , "store"])->name('insumoProveedor.store');
    Route::get('insumoProveedor/{idInsumoFK}/{idProveedorFK}', [InsumoProveedorController::class,'show'])->name('insumoProveedor.show');
    Route::put('insumoProveedor/{idInsumoFK}/{idProveedorFK}', [InsumoProveedorController::class , "update"])->name('insumoProveedor.update');
    Route::delete('insumoProveedor/{idInsumoFK}/{idProveedorFK}', [InsumoProveedorController::class,'destroy'])->name('insumoProveedor.destroy');

    // ------------------- Consultas -------------------

    Route::get("clientesEnCompraFechaEspecifica/{fecha}", [ConsultasController::class, 'clientesEnCompraFechaEspecifica'])->name("clientesEnCompraFechaEspecifica");
    Route::get('/ventas-julio-2023', [ConsultasController::class, 'ventasJulio2023']);
    Route::get('/empleados-con-cargos-y-municipios', [ConsultasController::class, 'empleadosConCargosYMunicipios']);
    Route::get('/ventas-con-clientes-y-forma-pago', [ConsultasController::class, 'ventasConClientesYFormaPago']);
    Route::get('/ordenes-con-detalles', [ConsultasController::class, 'ordenesConDetalles']);
    Route::get('/inventario-con-detalles', [ConsultasController::class, 'inventarioConDetalles']);
    Route::get('/proovedores-con-insumos', [ConsultasController::class, 'proovedoresConInsumos']);
    Route::get('/cantidad-ventas-por-empleado', [ConsultasController::class, 'cantidadVentasPorEmpleado']);
    Route::get('/ordenes-en-proceso', [ConsultasController::class, 'ordenesEnProceso']);
    Route::get('/empresa-y-municipio', [ConsultasController::class, 'empresaYMunicipio']);
    Route::get('/empleados-duracion-empleo', [ConsultasController::class, 'empleadosDuracionEmpleo']);
    Route::get('/valor-total-ventas-por-prenda-usd', [ConsultasController::class, 'ValorTotalVentasPorPrendaUsd']);
    Route::get('/cantidades-max-y-min-fabricacion-de-insumo-por-prendas', [ConsultasController::class, 'cantidadesMaxYMinFabricacionDeInsumoPorPrendas']);
    Route::get('/stock-prendas', [ConsultasController::class, 'stockPrendas']);
    Route::get('/ventas-rango-fechas/{fecha_inicio}/{fecha_fin}', [ConsultasController::class, 'ventasRangoFechas']);
    Route::get('/prendas-con-estado', [ConsultasController::class, 'prendasConEstado']);
    Route::get('/empleados-por-fecha-ingreso', [ConsultasController::class, 'empleadosPorFechaIngreso']);
    Route::get('/tipo-proteccion-con-su-cantidad-prendas', [ConsultasController::class, 'tipoProteccionConSuCantidadPrendas']);
    Route::get('/estado-con-cantidad-prendas', [ConsultasController::class, 'estadoConCantidadPrendas']);
    Route::get('/prenda-junto-valor-total-ventas-cop', [ConsultasController::class, 'prendaJuntoValorTotalVentasCop']);
    Route::get('/total-gastado-por-cliente', [ConsultasController::class, 'totalGastadoPorCliente']);
});



Route::group(['middleware' => ['json.response']], function () {
    Route::post("/gen_jwt", [UserController::class, 'generateJWT'])->name("gen_jwt");
    Route::post("/register", [UserController::class, 'register'])->name("register");
    Route::post("/login", [UserController::class, 'login'])->name("login");
});
