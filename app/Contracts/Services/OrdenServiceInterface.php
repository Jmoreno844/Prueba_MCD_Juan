<?php
namespace App\Contracts\Services;
use App\Dtos\OrdenDTO;
interface OrdenServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(OrdenDTO $ordenDTO);
    public function update($id, OrdenDTO $ordenDTO);
    public function destroy($id);
}