<?php
namespace App\Contracts\Services;
use App\Dtos\TipoPersonaDTO;
interface TipoPersonaServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(TipoPersonaDTO $tipoPersonaDTO);
    public function update($id, TipoPersonaDTO $tipoPersonaDTO);
    public function destroy($id);
}