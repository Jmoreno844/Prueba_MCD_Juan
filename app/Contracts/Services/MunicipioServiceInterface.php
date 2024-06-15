<?php
namespace App\Contracts\Services;
use App\Dtos\MunicipioDTO;
interface MunicipioServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(MunicipioDTO $municipioDTO);
    public function update($id, MunicipioDTO $municipioDTO);
    public function destroy($id);
}