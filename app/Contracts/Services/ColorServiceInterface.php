<?php
namespace App\Contracts\Services;
use App\Dtos\ColorDTO;
interface ColorServiceInterface
{
    public function index($perPage);
    public function show($id);
    public function store(ColorDTO $colorDTO);
    public function update($id, ColorDTO $colorDTO);
    public function destroy($id);
}