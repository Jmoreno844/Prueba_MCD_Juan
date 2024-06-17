<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\Controller;
use App\Services\ConsultasService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Consultas",
 *     description="Endpoints para consultas de datos"
 * )
 */
class ConsultasController extends Controller
{
    protected $consultasService;

    public function __construct(ConsultasService $consultasService)
    {
        $this->consultasService = $consultasService;
    }

    /**
     * @OA\Get(
     *     path="/api/ventas-julio-2023",
     *     tags={"Consultas"},
     *     summary="Obtener ventas de Julio 2023",
     *     description="Retorna las ventas de Julio 2023",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function ventasJulio2023()
    {
        $results = $this->consultasService->ventasJulio2023();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/empleados-cargos-municipios",
     *     tags={"Consultas"},
     *     summary="Obtener empleados con cargos y municipios",
     *     description="Retorna una lista de empleados con sus cargos y municipios",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function empleadosConCargosYMunicipios()
    {
        $results = $this->consultasService->empleadosConCargosYMunicipios();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/ventas-clientes-forma-pago",
     *     tags={"Consultas"},
     *     summary="Obtener ventas con clientes y forma de pago",
     *     description="Retorna una lista de ventas con información de clientes y forma de pago",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function ventasConClientesYFormaPago()
    {
        $results = $this->consultasService->ventasConClientesYFormaPago();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/ordenes-detalles",
     *     tags={"Consultas"},
     *     summary="Obtener ordenes con detalles y nombres de clientes y empleados asociados.",
     *     description="Retorna una lista de ordenes con sus detalles",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function ordenesConDetalles()
    {
        $results = $this->consultasService->ordenesConDetalles();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/inventario-detalles",
     *     tags={"Consultas"},
     *     summary="Obtener las prendas en inventario con sus detalles,talla y color.",
     *     description="Retorna una lista del inventario con sus detalles",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function inventarioConDetalles()
    {
        $results = $this->consultasService->inventarioConDetalles();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/proveedores-insumos",
     *     tags={"Consultas"},
     *     summary="Obtener proveedores con insumos",
     *     description="Retorna una lista de proveedores con sus insumos",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function proovedoresConInsumos()
    {
        $results = $this->consultasService->proovedoresConInsumos();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/cantidad-ventas-empleado",
     *     tags={"Consultas"},
     *     summary="Obtener cantidad de ventas por empleado",
     *     description="Retorna la cantidad de ventas realizadas por cada empleado",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function cantidadVentasPorEmpleado()
    {
        $results = $this->consultasService->cantidadVentasPorEmpleado();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/ordenes-en-proceso",
     *     tags={"Consultas"},
     *     summary="Obtener ordenes en proceso junto clientes y asociados.",
     *     description="Retorna una lista de ordenes que están en proceso junto los ell nombre de clientes y
     *      empleados asociados a cada orden.",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function ordenesEnProceso()
    {
        $results = $this->consultasService->ordenesEnProceso();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/empresa-municipio",
     *     tags={"Consultas"},
     *     summary="Obtener empresas con municipio",
     *     description="Retorna una lista de empresas con su municipio",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function empresaYMunicipio()
    {
        $results = $this->consultasService->empresaYMunicipio();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/clientesEnCompraFechaEspecifica/{fecha}",
     *     tags={"Consultas"},
     *     summary="Obtener clientes en una fecha específica",
     *     description="Retorna una lista de clientes que hicieron compras en una fecha específica",
     *     @OA\Parameter(
     *         required=true,
     *         name="fecha",
     *         in="path",
     *        description="Fecha en formato 'YYYY-MM-DD'",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function clientesEnCompraFechaEspecifica($fecha)
    {
        $results = $this->consultasService->clientesEnCompraFechaEspecifica($fecha);
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/empleados-duracion-empleo",
     *     tags={"Consultas"},
     *     summary="Obtener duración de empleo de empleados",
     *     description="Retorna la duración del empleo de los empleados",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function empleadosDuracionEmpleo()
    {
        $results = $this->consultasService->empleadosDuracionEmpleo();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/valor-total-ventas-por-prenda-usd",
     *     tags={"Consultas"},
     *     summary="Obtener valor total de ventas por prenda en USD de todas las prendas.",
     *     description="Retorna el valor total de ventas por prenda en USD de todas las prendas.",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function valorTotalVentasPorPrendaUsd()
    {
        $results = $this->consultasService->valorTotalVentasPorPrendaUsd();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/cantidades-max-y-min-fabricacion-de-insumo-por-prendas",
     *     tags={"Consultas"},
     *     summary="Obtener cantidades máximas y mínimas de fabricación de insumo por prendas",
     *     description="Retorna las cantidades máximas y mínimas de fabricación de insumo por prendas",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function cantidadesMaxYMinFabricacionDeInsumoPorPrendas()
    {
        $results = $this->consultasService->cantidadesMaxYMinFabricacionDeInsumoPorPrendas();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/stock-prendas",
     *     tags={"Consultas"},
     *     summary="Obtener stock de prendas.",
     *     description="Retorna una lista del prendas en stock.",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function stockPrendas()
    {
        $results = $this->consultasService->stockPrendas();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/ventas-rango-fechas/{fecha_inicio}/{fecha_fin",
     *     tags={"Consultas"},
     *     summary="Obtener ventas en un rango de fechas",
     *     description="Retorna una lista de ventas en un rango de fechas",
     *   @OA\Parameter(
     *         required=true,
     *         name="fecha_inicio",
     *         in="path",
     *        description="Fecha en formato 'YYYY-MM-DD'",
     *     ),
     *  @OA\Parameter(
     *         required=true,
     *         name="fecha_fin",
     *         in="path",
     *        description="Fecha en formato 'YYYY-MM-DD'",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function ventasRangoFechas($fecha_inicio, $fecha_fin = null)
    {
        $results = $this->consultasService->ventasRangoFechas($fecha_inicio, $fecha_fin);
        return response()->json($results);
    }



    /**
     * @OA\Get(
     *     path="/api/prendas-estado",
     *     tags={"Consultas"},
     *     summary="Obtener prendas con estado",
     *     description="Retorna una lista de prendas con su estado",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function prendasConEstado()
    {
        $results = $this->consultasService->prendasConEstado();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/empleados-fecha-ingreso",
     *     tags={"Consultas"},
     *     summary="Obtener empleados por fecha de ingreso",
     *     description="Retorna una lista de empleados por su fecha de ingreso",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function empleadosPorFechaIngreso()
    {
        $results = $this->consultasService->empleadosPorFechaIngreso();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/tipo-proteccion-cantidad-prendas",
     *     tags={"Consultas"},
     *     summary="Obtener tipo de protección con su cantidad de prendas",
     *     description="Retorna una lista del tipo de protección con su cantidad de prendas",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function tipoProteccionConSuCantidadPrendas()
    {
        $results = $this->consultasService->tipoProteccionConSuCantidadPrendas();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/estado-cantidad-prendas",
     *     tags={"Consultas"},
     *     summary="Obtener estado con cantidad de prendas",
     *     description="Retorna una lista del estado con su cantidad de prendas",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function estadoConCantidadPrendas()
    {
        $results = $this->consultasService->estadoConCantidadPrendas();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/prenda-junto-valor-total-ventas-cop",
     *     tags={"Consultas"},
     *     summary="Obtener prenda junto a su valor total de ventas en COP",
     *     description="Retorna una lista de prendas con su valor total de ventas en COP",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function prendaJuntoValorTotalVentasCop()
    {
        $results = $this->consultasService->prendaJuntoValorTotalVentasCop();
        return response()->json($results);
    }

    /**
     * @OA\Get(
     *     path="/api/total-gastado-por-cliente",
     *     tags={"Consultas"},
     *     summary="Obtener total gastado por cliente",
     *     description="Retorna el total gastado por cada cliente",
     *     @OA\Response(
     *         response=200,
     *         description="Operación exitosa",
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="Ha ocurrido un error",
     *     )
     * )
     */
    public function totalGastadoPorCliente()
    {
        $results = $this->consultasService->totalGastadoPorCliente();
        return response()->json($results);
    }
}
