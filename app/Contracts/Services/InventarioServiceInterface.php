<?php
namespace App\Contracts\Services;
use App\Dtos\InventarioDTO;
interface InventarioServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(InventarioDTO $inventarioDTO);
    public function update($id, InventarioDTO $inventarioDTO);
    public function destroy($id);
}