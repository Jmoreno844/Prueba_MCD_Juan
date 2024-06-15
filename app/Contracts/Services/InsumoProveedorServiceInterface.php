<?php
namespace App\Contracts\Services;
use App\Dtos\InsumoProveedorDTO;
interface InsumoProveedorServiceInterface
{
    public function index($perPage);
    public function show($id1,$id2);
    public function store($id1,$id2);
    public function destroy($id1,$id2);
}
