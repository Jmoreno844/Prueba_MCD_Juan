<?php
namespace App\Contracts\Services;
use App\Dtos\PaisDTO;
interface PaisServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(PaisDTO $paisDTO);
    public function update($id, PaisDTO $paisDTO);
    public function destroy($id);
}