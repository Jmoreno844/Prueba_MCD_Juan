<?php
namespace App\Contracts\Services;
use App\Dtos\DetalleVentaDTO;
interface DetalleVentaServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(DetalleVentaDTO $detalleVentaDTO);
    public function update($id, DetalleVentaDTO $detalleVentaDTO);
    public function destroy($id);
}