<?php
namespace App\Contracts\Services;
use App\Dtos\InsumoPrendasDTO;
interface InsumoPrendasServiceInterface
{
    public function index($perPage);
    public function show($id1, $id2);
    public function store($id1, $id2, $cantidad);
    public function update($id1, $id2, $cantidad);
    public function destroy($id1 , $id2);
}
