<?php
namespace App\Contracts\Services;
use App\Dtos\GeneroDTO;
interface GeneroServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(GeneroDTO $generoDTO);
    public function update($id, GeneroDTO $generoDTO);
    public function destroy($id);
}