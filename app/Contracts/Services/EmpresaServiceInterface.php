<?php
namespace App\Contracts\Services;
use App\Dtos\EmpresaDTO;
interface EmpresaServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(EmpresaDTO $empresaDTO);
    public function update($id, EmpresaDTO $empresaDTO);
    public function destroy($id);
}