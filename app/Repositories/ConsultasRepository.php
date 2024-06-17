<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ConsultasRepository
{
    public function ventasJulio2023()
    {
        return DB::table('venta')
            ->whereMonth('Fecha', 7)
            ->whereYear('fecha', 2023)
            ->paginate(10);
    }

    public function empleadosConCargosYMunicipios()
    {
        return DB::table('empleado as emp')
            ->join('cargos as c', 'emp.idCargoFK', '=', 'c.id')
            ->join('municipio as m', 'emp.IdMunicipioFK', '=', 'm.id')
            ->select('emp.*', 'c.descripcion as Cargo', 'm.nombre as Municipio')
            ->paginate(10);
    }

    public function ventasConClientesYFormaPago()
    {
        return DB::table('venta as v')
            ->join('cliente as c', 'v.IdClienteFK', '=', 'c.id')
            ->join('forma_pago as fpago', 'v.IdFormaPagoFK', '=', 'fpago.id')
            ->select('v.*', 'c.*', 'fpago.Descripcion')
            ->paginate(10);
    }

    public function ordenesConDetalles()
    {
        return DB::table('orden as o')
            ->join('empleado as e', 'o.IdEmpleadoFK', '=', 'e.id')
            ->join('cliente as c', 'o.IdClienteFK', '=', 'c.id')
            ->join('estado as est', 'o.IdEstadoFK', '=', 'est.id')
            ->select('o.*', 'e.nombre as nombreEmpleado', 'c.nombre as nombreCliente', 'est.Descripcion as estadoFactura')
            ->paginate(10);
    }

    public function inventarioConDetalles()
    {
        return DB::table('inventario as i')
            ->join('prenda', 'i.IdPrendaFK', '=', 'prenda.id')
            ->join('color', 'i.IdColorFK', '=', 'color.id')
            ->join('talla', 'i.IdTallaFK', '=', 'talla.id')
            ->join('genero as g', 'prenda.IdGeneroFK', '=', 'g.id')
            ->join('tipo_proteccion as tp', 'prenda.IdTipoProteccionFK', '=', 'tp.id')
            ->select('i.CodInv', 'prenda.id', 'prenda.Codigo', 'prenda.Nombre', 'prenda.ValorUnitUsd', 'prenda.ValorUnitCop', 'tp.Descripcion as tipoProteccion', 'color.Descripcion as color', 'talla.Descripcion as talla', 'g.descripcion as genero')
            ->paginate(10);
    }

    public function proovedoresConInsumos()
    {
        return DB::table('proveedor as p')
            ->join('insumo_proveedor', 'insumo_proveedor.IdProveedorFK', '=', 'p.id')
            ->join('insumo as i', 'insumo_proveedor.IdInsumoFK', '=', 'i.id')
            ->join('tipo_persona as tp', 'p.IdTipoPersona', '=', 'tp.id')
            ->join('municipio', 'p.IdMunicipioFK', '=', 'municipio.id')
            ->select('p.id as id_proveedor', 'p.NitProovedor', 'p.Nombre as nombre_proveedor', 'tp.Nombre as tipo_persona', 'municipio.Nombre as municipio', 'i.id as id_insumo', 'i.Nombre as nombre_insumo', 'i.valor_unit', 'i.stock_min', 'i.stock_max')
            ->paginate(10);
    }

    public function cantidadVentasPorEmpleado()
    {
        return DB::table('empleado as e')
            ->join('cargos', 'e.idCargoFK', '=', 'cargos.id')
            ->join('municipio', 'e.IdMunicipioFK', '=', 'municipio.id')
            ->join('venta', 'venta.IdEmpleadoFK', '=', 'e.id')
            ->select('e.id as id_empleado', 'e.nombre', 'e.fecha_ingreso', 'cargos.descripcion as cargo', 'municipio.nombre as municipio', DB::raw('COUNT(venta.id) AS cantidad_ventas'))
            ->groupBy('e.id', 'e.nombre', 'e.fecha_ingreso', 'cargos.descripcion', 'municipio.nombre')
            ->paginate(10);
    }

    public function ordenesEnProceso()
    {
        return DB::table('orden')
            ->join('cliente', 'orden.IdClienteFK', '=', 'cliente.id')
            ->join('empleado', 'orden.IdEmpleadoFK', '=', 'empleado.id')
            ->join('estado', 'orden.IdEstadoFK', '=', 'estado.id')
            ->select('orden.id as id_orden', 'orden.fecha', 'estado.Descripcion as estado_orden', 'empleado.nombre as nombre_empleado', 'cliente.nombre as nombre_cliente')
            ->where('estado.id', 6)
            ->paginate(10);
    }

    public function empresaYMunicipio()
    {
        return DB::table('empresa')
            ->join('municipio', 'empresa.IdMunicipioFK', '=', 'municipio.id')
            ->select('empresa.*', 'municipio.nombre as nombre_municipio')
            ->paginate(10);
    }

    public function clientesEnCompraFechaEspecifica($fecha)
    {
        return DB::table('detalle_venta as d')
            ->join('venta as v', 'd.idVentaFK', '=', 'v.id')
            ->join('cliente as c', 'v.IdClienteFK', '=', 'c.id')
            ->select('c.nombre as nombre_cliente', DB::raw('COUNT(d.idVentaFK) as cantidad_articulos_comprados'))
            ->whereDate('v.Fecha', $fecha)
            ->groupBy('c.nombre')
            ->paginate(10);
    }

    public function empleadosDuracionEmpleo()
    {
        return DB::table('empleado')
            ->select('empleado.*', DB::raw('TIMESTAMPDIFF(YEAR, empleado.fecha_ingreso, CURDATE()) as num_años_transcurridos'))
            ->paginate(10);
    }

    public function valorTotalVentasPorPrendaUsd()
    {
        return DB::table('prenda')
            ->join('inventario', 'inventario.IdPrendaFK', '=', 'prenda.id')
            ->join('detalle_venta', 'detalle_venta.IdInventarioFK', '=', 'inventario.id')
            ->select('prenda.id as id_prenda', 'prenda.Nombre as nombre_prenda', DB::raw('SUM(inventario.Cantidad) as cantidad_prendas_vendidas'), 'prenda.ValorUnitUsd as valor_unitario_usd', DB::raw('SUM(inventario.Cantidad)*prenda.ValorUnitUsd as valor_ventas_usd'))
            ->groupBy('prenda.id', 'prenda.Nombre', 'prenda.ValorUnitUsd')
            ->paginate(10);
    }

    public function cantidadesMaxYMinFabricacionDeInsumoPorPrendas()
    {
        return DB::table('prenda')
            ->join('insumo_prendas', 'insumo_prendas.IdPrendaFK', '=', 'prenda.id')
            ->join('insumo', 'insumo_prendas.IdInsumoFK', '=', 'insumo.id')
            ->select('prenda.id as id_prenda', 'prenda.Nombre as nombre_prenda', 'insumo.stock_min as cantidad_minima_insumos_para_fabricacion', 'insumo.stock_max as cantidad_maxima_insumos_para_fabricacion')
            ->paginate(10);
    }

    public function stockPrendas()
    {
        return DB::table('prenda')
            ->join('inventario', 'inventario.IdPrendaFK', '=', 'prenda.id')
            ->join('tipo_proteccion', 'prenda.IdTipoProteccionFK', '=', 'tipo_proteccion.id')
            ->join('genero', 'prenda.IdGeneroFK', '=', 'genero.id')
            ->join('talla', 'inventario.IdTallaFK', '=', 'talla.id')
            ->join('color', 'inventario.IdColorFK', '=', 'color.id')
            ->select('prenda.id as id_prenda', 'prenda.Nombre', 'genero.descripcion as genero', 'talla.Descripcion as talla', 'color.Descripcion as color', 'tipo_proteccion.Descripcion as tipo_proteccion', 'prenda.ValorUnitCop', 'prenda.ValorUnitUsd', 'inventario.Cantidad')
            ->paginate(10);
    }

    public function ventasRangoFechas($fecha_inicio, $fecha_fin)
    {
        return DB::table('venta')
            ->join('empleado', 'venta.IdEmpleadoFK', '=', 'empleado.id')
            ->join('forma_pago', 'venta.IdFormaPagoFK', '=', 'forma_pago.id')
            ->select('venta.*', 'empleado.nombre as nombre_empleado', 'forma_pago.descripcion as descripcion_pago')
            ->whereBetween('venta.fecha', [$fecha_inicio, $fecha_fin])
            ->paginate(10);
    }

    public function prendasConEstado()
    {
        return DB::table('prenda')
            ->join('estado', 'prenda.IdEstadoFK', '=', 'estado.id')
            ->select('prenda.id as id_prenda', 'prenda.Nombre', 'prenda.ValorUnitUsd', 'estado.Descripcion as estado')
            ->paginate(10);
    }

    public function empleadosPorFechaIngreso()
    {
        return DB::table('empleado')
            ->join('cargos', 'empleado.idCargoFK', '=', 'cargos.id')
            ->select('empleado.id as id_empleado', 'empleado.nombre', 'cargos.descripcion as cargo', 'empleado.fecha_ingreso')
            ->orderBy('empleado.fecha_ingreso', 'DESC')
            ->paginate(10);
    }

    public function tipoProteccionConSuCantidadPrendas()
    {
        return DB::table('tipo_proteccion')
            ->join('prenda', 'tipo_proteccion.id', '=', 'prenda.IdTipoProteccionFK')
            ->join('inventario', 'prenda.id', '=', 'inventario.IdPrendaFK')
            ->select('tipo_proteccion.id as id_tipo_proteccion', 'tipo_proteccion.Descripcion as nombre', DB::raw('SUM(inventario.Cantidad) as cantidad_prendas'))
            ->groupBy('tipo_proteccion.id')
            ->paginate(10);
    }

    public function estadoConCantidadPrendas()
    {
        return DB::table('empleado')
            ->join('cargos', 'empleado.idCargoFK', '=', 'cargos.id')
            ->select('empleado.id as id_empleado', 'empleado.nombre', 'cargos.descripcion as cargo', 'empleado.fecha_ingreso')
            ->orderBy('empleado.fecha_ingreso')
            ->paginate(10);
    }

    public function prendaJuntoValorTotalVentasCop()
    {
        return DB::table('prenda')
            ->join('inventario', 'inventario.IdPrendaFK', '=', 'prenda.id')
            ->join('detalle_venta', 'detalle_venta.IdInventarioFK', '=', 'inventario.id')
            ->join('venta', 'venta.id', '=', 'detalle_venta.IdVentaFK')
            ->select('prenda.id as id_prenda', 'prenda.Nombre as nombre_prenda', DB::raw('SUM(inventario.Cantidad) as cantidad_prendas_vendidas'), 'prenda.ValorUnitCop as valor_unitario_cop', DB::raw('SUM(detalle_venta.Cantidad)*prenda.ValorUnitCop as valor_ventas_cop'))
            ->groupBy('prenda.id')
            ->paginate(10);
    }

    public function totalGastadoPorCliente()
    {
        return DB::table('cliente')
            ->join('venta', 'cliente.id', '=', 'venta.IdClienteFK')
            ->join('detalle_venta', 'detalle_venta.IdVentaFK', '=', 'venta.id')
            ->join('inventario', 'inventario.id', '=', 'detalle_venta.IdInventarioFK')
            ->join('prenda', 'inventario.IdPrendaFK', '=', 'prenda.id')
            ->select('cliente.id as id_cliente', 'cliente.nombre as nombre_cliente', DB::raw('COUNT(venta.IdClienteFK) as ventas_hechas'), DB::raw('SUM(detalle_venta.Cantidad * prenda.ValorUnitCop) as total_gastado'))
            ->groupBy('cliente.id', 'cliente.nombre')
            ->paginate(10);
    }
}
