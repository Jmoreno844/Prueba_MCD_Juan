<?php
namespace App\Contracts\Services;
use App\Dtos\CargoDTO;
interface CargoServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(CargoDTO $cargoDTO);
    public function update($id, CargoDTO $cargoDTO);
    public function destroy($id);
}