<?php
namespace App\Contracts\Services;
use App\Dtos\EstadoDTO;
interface EstadoServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(EstadoDTO $estadoDTO);
    public function update($id, EstadoDTO $estadoDTO);
    public function destroy($id);
}