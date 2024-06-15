<?php
namespace App\Contracts\Services;
use App\Dtos\VentaDTO;
interface VentaServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(VentaDTO $ventaDTO);
    public function update($id, VentaDTO $ventaDTO);
    public function destroy($id);
}