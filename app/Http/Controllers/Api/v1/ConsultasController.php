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

    public function base() {
        $results = DB::select("");
        return response()->json($results);
    }

   /* public function base() {
        $results = DB::select("");
        return response()->json($results);
    }*/
}
