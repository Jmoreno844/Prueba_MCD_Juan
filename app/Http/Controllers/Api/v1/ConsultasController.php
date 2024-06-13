<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\Controller;
use Illuminate\Http\Request;
use DB;
class ConsultasController extends Controller
{
    public function ventasJulio2023(){
        $results = DB::select("SELECT * FROM venta
                              WHERE MONTH(venta.Fecha) = 7
                              AND YEAR(venta.fecha) = 2023;");
        return response()->json($results);
    }

    public function empleadosConCargosYMunicipios() {
        $results = DB::select("SELECT emp.*, c.descripcion as Cargo, m.nombre as Municipio
                               FROM cargos c, municipio m, empleado emp
                               WHERE emp.IdMunicipioFK = m.id
                               AND emp.idCargoFK = c.id;");
        return response()->json($results);
    }

    public function ventasConClientesYFormaPago() {
        $results = DB::select("SELECT v.*, c.*, fpago.Descripcion
                              FROM venta v, cliente c, forma_pago fpago
                              WHERE v.IdClienteFK = c.id
                              AND v.IdFormaPagoFK = fpago.id");
        return response()->json($results);
    }

    public function ordenesConDetalles() {
        $results = DB::select("SELECT o.*, e.nombre nombreEmpleado, c.nombre AS nombreCliente , est.Descripcion AS estadoFactura
                               FROM orden o, empleado e, cliente c, estado est
                               WHERE o.IdEmpleadoFK = e.id
                               AND o.IdClienteFK = c.id
                               AND o.IdEstadoFK = est.id");
        return response()->json($results);
    }

    public function inventarioConDetalles() {
        $results = DB::select("SELECT i.CodInv, prenda.id, prenda.Codigo, prenda.Nombre, prenda.ValorUnitUsd, prenda.ValorUnitCop,
                               tp.Descripcion as tipoProteccion, color.Descripcion as color, talla.Descripcion AS talla,
                               g.descripcion AS genero
                               FROM inventario i
                               JOIN prenda ON i.IdPrendaFK = prenda.id
                               JOIN color ON i.IdColorFK = color.id
                               JOIN talla ON i.IdTallaFK = talla.id
                               JOIN genero g ON prenda.IdGeneroFK = g.id
                               JOIN tipo_proteccion tp ON prenda.IdTipoProteccionFK = tp.id");

        return response()->json($results);
    }

    public function proovedoresConInsumos() {
        $results = DB::select("
        SELECT
            p.id AS id_proveedor,
            p.NitProovedor,
            p.Nombre AS nombre_proveedor,
            tp.Nombre AS tipo_persona,
            municipio.Nombre AS municipio,
            i.id AS id_insumo,
            i.Nombre AS nombre_insumo,
            i.valor_unit AS valor_unit,
            i.stock_min AS stock_min,
            i.stock_max AS stock_max
        FROM
            proveedor p
        JOIN
            insumo_proveedor ON insumo_proveedor.IdProveedorFK = p.id
        JOIN
            insumo i ON insumo_proveedor.IdInsumoFK = i.id
        JOIN
            tipo_persona tp ON p.IdTipoPersona = tp.id
        JOIN
            municipio ON p.IdMunicipioFK = municipio.id");

        return response()->json($results);
    }

    public function cantidadVentasPorEmpleado() {
        $results = DB::select("SELECT e.id AS id_empleado,
                              e.nombre,
                              e.fecha_ingreso,
                              cargos.descripcion AS cargo,
                              municipio.nombre AS municipio,
                              COUNT(venta.id) AS cantidad_ventas
                              FROM empleado e
                              JOIN cargos ON e.idCargoFK = cargos.id
                              JOIN municipio ON e.IdMunicipioFK = municipio.id
                              JOIN venta ON venta.IdEmpleadoFK = e.id
                              GROUP BY e.id, e.nombre, e.fecha_ingreso, cargos.descripcion, municipio.nombre;");
        return response()->json($results);
    }

    public function ordenesEnProceso() {
        $results = DB::select("SELECT orden.id AS id_orden,
                               orden.fecha,
                               estado.Descripcion as estado_orden,
                               empleado.nombre as nombre_empleado,
                               cliente.nombre as nombre_cliente
                               FROM orden
                               JOIN cliente ON orden.IdClienteFK = cliente.id
                               JOIN empleado ON orden.IdEmpleadoFK = empleado.id
                               JOIN estado ON orden.IdEstadoFK = estado.id
                               WHERE estado.id = 6");
        return response()->json($results);
    }

   public function empresaYMunicipio() {
        $results = DB::select("SELECT empresa.*,
                               municipio.nombre AS nombre_municipio
                               FROM empresa
                               JOIN municipio ON empresa.IdMunicipioFK = municipio.id");
        return response()->json($results);
    }

    public function clientesEnCompraFechaEspecifica($fecha)
    {
        $resultados = DB::select("SELECT c.nombre AS nombre_cliente, COUNT(d.idVentaFK) AS cantidad_articulos_comprados
                                  FROM detalle_venta d
                                  JOIN venta v ON d.idVentaFK = v.id
                                  JOIN cliente c ON v.IdClienteFK = c.id
                                  WHERE v.Fecha = :fecha
                                  GROUP BY c.nombre",
                                 ['fecha' => $fecha]);

        return response()->json($resultados);
    }
    public function empleadosDuracionEmpleo() {
        $results = DB::select("SELECT empleado.* ,
                              TIMESTAMPDIFF(YEAR, empleado.fecha_ingreso, CURDATE()) AS num_años_transcurridos
                              FROM empleado;");

        return response()->json($results);
    }

    public function ValorTotalVentasPorPrendaUsd() {
        $results = DB::select("SELECT prenda.id as id_prenda,
                               prenda.Nombre AS nombre_prenda,
                               SUM(inventario.Cantidad) as  cantidad_prendas_vendidas,
                               prenda.ValorUnitUsd AS valor_unitario_usd,
                               SUM(inventario.Cantidad)*prenda.ValorUnitUsd AS valor_ventas_usd
                               FROM prenda
                               JOIN inventario ON inventario.IdPrendaFK = prenda.id
                               JOIN detalle_venta ON detalle_venta.IdInventarioFK = inventario.id
                               GROUP BY prenda.id, prenda.Nombre, prenda.ValorUnitUsd;");
        return response()->json($results);
    }

    public function cantidadesMaxYMinFabricacionDeInsumoPorPrendas() {
        $results = DB::select("SELECT prenda.id as id_prenda,
                               prenda.Nombre as nombre_prenda,
                               insumo.stock_min as cantidad_minima_insumos_para_fabricacion,
                               insumo.stock_max as cantidad_maxima_insumos_para_fabricacion
                               FROM prenda
                               JOIN insumo_prendas ON insumo_prendas.IdPrendaFK = prenda.id
                               JOIN insumo ON insumo_prendas.IdInsumoFK = insumo.id");
        return response()->json($results);
    }

    public function stockPrendas() {
        $results = DB::select("SELECT prenda.id as id_prenda,
                               prenda.Nombre,
                               genero.descripcion as genero,
                               talla.Descripcion as talla,
                               color.Descripcion as color,
                               tipo_proteccion.Descripcion as tipo_proteccion,
                               prenda.ValorUnitCop,
                               prenda.ValorUnitUsd,
                               inventario.Cantidad
                               FROM prenda
                               JOIN inventario ON inventario.IdPrendaFK = prenda.id
                               JOIN tipo_proteccion ON prenda.IdTipoProteccionFK = tipo_proteccion.id
                               JOIN genero on prenda.IdGeneroFK = genero.id
                               JOIN talla ON inventario.IdTallaFK = talla.id
                               JOIN color ON inventario.IdColorFK = color.id");

        return response()->json($results);
    }

    public function ventasRangoFechas($fecha_inicio, $fecha_fin) {
        $results = DB::select("SELECT
                               venta.*,
                               empleado.nombre AS nombre_empleado,
                               forma_pago.descripcion AS descripcion_pago
                               FROM venta
                               JOIN empleado ON venta.IdEmpleadoFK = empleado.id
                               JOIN forma_pago ON venta.IdFormaPagoFK = forma_pago.id
                               WHERE venta.fecha BETWEEN :fecha_inicio AND :fecha_fin",
                              ["fecha_inicio" => $fecha_inicio, 'fecha_fin' => $fecha_fin]);

        return response()->json($results);
    }


    public function prendasConEstado() {
        $results = DB::select("SELECT prenda.id as id_prenda,
                               prenda.Nombre,
                               prenda.ValorUnitUsd,
                               estado.Descripcion as estado
                               FROM prenda, estado
                               WHERE prenda.IdEstadoFK = estado.id");
        return response()->json($results);
    }

    public function empleadosPorFechaIngreso() {
        $results = DB::select("SELECT empleado.id as id_empleado,
                              empleado.nombre,
                              cargos.descripcion as cargo,
                              empleado.fecha_ingreso
                              FROM empleado, cargos
                              WHERE empleado.idCargoFK = cargos.id
                              ORDER BY empleado.fecha_ingreso DESC");

        return response()->json($results);
    }

    public function tipoProteccionConSuCantidadPrendas() {
        $results = DB::select("SELECT tipo_proteccion.id as id_tipo_proteccion,
                               tipo_proteccion.Descripcion as nombre,
                               SUM(inventario.Cantidad) as cantidad_prendas
                               FROM tipo_proteccion, prenda
                               JOIN inventario ON prenda.id = inventario.IdPrendaFK
                               WHERE tipo_proteccion.id = prenda.IdTipoProteccionFK
                               GROUP BY tipo_proteccion.id");
        return response()->json($results);
    }

    public function estadoConCantidadPrendas() {
        $results = DB::select("SELECT empleado.id as id_empleado,
                               empleado.nombre,
                               cargos.descripcion as cargo,
                               empleado.fecha_ingreso
                               FROM empleado, cargos
                               WHERE empleado.idCargoFK = cargos.id
                               ORDER BY empleado.fecha_ingreso;");
        return response()->json($results);
    }
    public function prendaJuntoValorTotalVentasCop() {
        $results = DB::select(
"SELECT prenda.id as id_prenda,
prenda.Nombre AS nombre_prenda,
SUM(inventario.Cantidad) as  cantidad_prendas_vendidas,
prenda.ValorUnitCop AS valor_unitario_cop,
SUM(detalle_venta.Cantidad)*prenda.ValorUnitCop AS valor_ventas_cop
FROM prenda
JOIN inventario ON inventario.IdPrendaFK = prenda.id
JOIN detalle_venta ON detalle_venta.IdInventarioFK = inventario.id
JOIN venta ON venta.id = detalle_venta.IdVentaFK
WHERE inventario.id = detalle_venta.IdInventarioFK
GROUP BY prenda.id;");
        return response()->json($results);
    }

    public function totalGastadoPorCliente() {
        $results = DB::select(
"SELECT cliente.id as id_cliente,
cliente.nombre AS nombre_cliente,
COUNT(venta.IdClienteFK) AS ventas_hechas,
SUM(detalle_venta.Cantidad * prenda.ValorUnitCop) AS total_gastado
FROM cliente
JOIN venta ON cliente.id = venta.IdClienteFK
JOIN detalle_venta ON detalle_venta.IdVentaFK = venta.id
JOIN inventario ON inventario.id = detalle_venta.IdInventarioFK
JOIN prenda ON inventario.IdPrendaFK = prenda.id
GROUP BY cliente.id, cliente.nombre;");
        return response()->json($results);
    }

}

