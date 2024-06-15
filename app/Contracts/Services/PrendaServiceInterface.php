<?php
namespace App\Contracts\Services;
use App\Dtos\PrendaDTO;
interface PrendaServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(PrendaDTO $prendaDTO);
    public function update($id, PrendaDTO $prendaDTO);
    public function destroy($id);
}