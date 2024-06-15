<?php
namespace App\Repositories;

use App\Contracts\Repositories\InsumoProveedorRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InsumoProveedorRepository implements InsumoProveedorRepositoryInterface
{
    protected $table = 'insumo_proveedor';

    public function index($perPage)
    {
        return DB::table($this->table)->paginate($perPage);
    }

    public function show($id1,$id2)
    {
        return DB::table($this->table)->where('IdInsumoFK', $id1)->where('IdProveedorFK', $id2)->first();
    }

    public function store($id1,$id2)
    {
        return DB::table($this->table)->insert(['IdInsumoFK' => $id1, 'IdProveedorFK' => $id2]);
    }

    public function destroy($id1,$id2)
    {
        return DB::table($this->table)->where('IdInsumoFK', $id1)->where('IdProveedorFK', $id2)->delete();
    }
}
