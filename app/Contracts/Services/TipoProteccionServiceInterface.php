<?php
namespace App\Contracts\Services;
use App\Dtos\TipoProteccionDTO;
interface TipoProteccionServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(TipoProteccionDTO $tipoProteccionDTO);
    public function update($id, TipoProteccionDTO $tipoProteccionDTO);
    public function destroy($id);
}