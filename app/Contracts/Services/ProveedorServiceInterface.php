<?php
namespace App\Contracts\Services;
use App\Dtos\ProveedorDTO;
interface ProveedorServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(ProveedorDTO $proveedorDTO);
    public function update($id, ProveedorDTO $proveedorDTO);
    public function destroy($id);
}