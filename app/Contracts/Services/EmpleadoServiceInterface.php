<?php
namespace App\Contracts\Services;
use App\Dtos\EmpleadoDTO;
interface EmpleadoServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(EmpleadoDTO $empleadoDTO);
    public function update($id, EmpleadoDTO $empleadoDTO);
    public function destroy($id);
}