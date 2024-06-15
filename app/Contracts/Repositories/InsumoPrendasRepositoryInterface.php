<?php
namespace App\Contracts\Repositories;

interface InsumoPrendasRepositoryInterface
{
    public function index($perPage);
    public function show($id1, $id2);
    public function store($id1, $id2, $data);
    public function update($id1, $id2, $data);
    public function destroy($id1, $id2);
}
