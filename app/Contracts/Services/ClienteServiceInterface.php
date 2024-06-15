<?php
namespace App\Contracts\Services;
use App\Dtos\ClienteDTO;
interface ClienteServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(ClienteDTO $clienteDTO);
    public function update($id, ClienteDTO $clienteDTO);
    public function destroy($id);
}