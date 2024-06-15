<?php
namespace App\Contracts\Services;
use App\Dtos\TallaDTO;
interface TallaServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(TallaDTO $tallaDTO);
    public function update($id, TallaDTO $tallaDTO);
    public function destroy($id);
}