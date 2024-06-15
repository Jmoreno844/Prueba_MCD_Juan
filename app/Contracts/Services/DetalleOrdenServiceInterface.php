<?php
namespace App\Contracts\Services;
use App\Dtos\DetalleOrdenDTO;
interface DetalleOrdenServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(DetalleOrdenDTO $detalleOrdenDTO);
    public function update($id, DetalleOrdenDTO $detalleOrdenDTO);
    public function destroy($id);
}