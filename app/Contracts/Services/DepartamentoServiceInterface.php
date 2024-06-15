<?php
namespace App\Contracts\Services;
use App\Dtos\DepartamentoDTO;
interface DepartamentoServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(DepartamentoDTO $departamentoDTO);
    public function update($id, DepartamentoDTO $departamentoDTO);
    public function destroy($id);
}