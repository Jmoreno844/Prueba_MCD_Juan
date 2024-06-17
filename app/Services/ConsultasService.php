<?php

namespace App\Services;

use App\Repositories\ConsultasRepository;

class ConsultasService
{
    protected $consultasRepository;

    public function __construct(ConsultasRepository $consultasRepository)
    {
        $this->consultasRepository = $consultasRepository;
    }

    public function ventasJulio2023()
    {
        return $this->consultasRepository->ventasJulio2023();
    }

    public function empleadosConCargosYMunicipios()
    {
        return $this->consultasRepository->empleadosConCargosYMunicipios();
    }

    public function ventasConClientesYFormaPago()
    {
        return $this->consultasRepository->ventasConClientesYFormaPago();
    }

    public function ordenesConDetalles()
    {
        return $this->consultasRepository->ordenesConDetalles();
    }

    public function inventarioConDetalles()
    {
        return $this->consultasRepository->inventarioConDetalles();
    }

    public function proovedoresConInsumos()
    {
        return $this->consultasRepository->proovedoresConInsumos();
    }

    public function cantidadVentasPorEmpleado()
    {
        return $this->consultasRepository->cantidadVentasPorEmpleado();
    }

    public function ordenesEnProceso()
    {
        return $this->consultasRepository->ordenesEnProceso();
    }

    public function empresaYMunicipio()
    {
        return $this->consultasRepository->empresaYMunicipio();
    }

    public function clientesEnCompraFechaEspecifica($fecha)
    {
        return $this->consultasRepository->clientesEnCompraFechaEspecifica($fecha);
    }

    public function empleadosDuracionEmpleo()
    {
        return $this->consultasRepository->empleadosDuracionEmpleo();
    }

    public function valorTotalVentasPorPrendaUsd()
    {
        return $this->consultasRepository->valorTotalVentasPorPrendaUsd();
    }

    public function cantidadesMaxYMinFabricacionDeInsumoPorPrendas()
    {
        return $this->consultasRepository->cantidadesMaxYMinFabricacionDeInsumoPorPrendas();
    }

    public function stockPrendas()
    {
        return $this->consultasRepository->stockPrendas();
    }

    public function ventasRangoFechas($fecha_inicio, $fecha_fin)
    {
        return $this->consultasRepository->ventasRangoFechas($fecha_inicio, $fecha_fin);
    }

    public function prendasConEstado()
    {
        return $this->consultasRepository->prendasConEstado();
    }

    public function empleadosPorFechaIngreso()
    {
        return $this->consultasRepository->empleadosPorFechaIngreso();
    }

    public function tipoProteccionConSuCantidadPrendas()
    {
        return $this->consultasRepository->tipoProteccionConSuCantidadPrendas();
    }

    public function estadoConCantidadPrendas()
    {
        return $this->consultasRepository->estadoConCantidadPrendas();
    }

    public function prendaJuntoValorTotalVentasCop()
    {
        return $this->consultasRepository->prendaJuntoValorTotalVentasCop();
    }

    public function totalGastadoPorCliente()
    {
        return $this->consultasRepository->totalGastadoPorCliente();
    }
}

