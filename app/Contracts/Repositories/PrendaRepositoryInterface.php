<?php
namespace App\Contracts\Repositories;

interface PrendaRepositoryInterface
{
    public function index($perPage);
    public function show($id);
    public function store(array $data);
    public function update($id, array $data);
    public function destroy($id);
}