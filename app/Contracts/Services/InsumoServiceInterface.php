<?php
namespace App\Contracts\Services;
use App\Dtos\InsumoDTO;
interface InsumoServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(InsumoDTO $insumoDTO);
    public function update($id, InsumoDTO $insumoDTO);
    public function destroy($id);
}