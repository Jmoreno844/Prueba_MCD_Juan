<?php
namespace App\Repositories;

use App\Contracts\Repositories\InsumoPrendasRepositoryInterface;
use Illuminate\Support\Facades\DB;

class InsumoPrendasRepository implements InsumoPrendasRepositoryInterface
{
    protected $table = 'insumo_prendas';

    public function index($perPage)
    {
        return DB::table($this->table)->paginate($perPage);
    }

    public function show($idInsumoFK, $idPrendaFK)
    {
        return DB::table($this->table)->where('IdInsumoFK', $idInsumoFK)->where("IdPrendaFK", $idPrendaFK)->first();
    }

    public function store($idInsumoFK, $idPrendaFK, $cantidad)
    {
        $data = [
            'IdInsumoFK' => $idInsumoFK,
            'IdPrendaFK' => $idPrendaFK,
            'Cantidad' => $cantidad
        ];
        return DB::table($this->table)->insert($data);
    }

    public function update($idInsumoFK, $idPrendaFK, $cantidad)
    {
        $data = [
            'Cantidad' => $cantidad
        ];
        return DB::table($this->table)->where('IdInsumoFK', $idInsumoFK)->where("IdPrendaFK", $idPrendaFK)->update($data);
    }

    public function destroy($idInsumoFK, $idPrendaFK)
    {
        return DB::table($this->table)->where('IdInsumoFK', $idInsumoFK)->where("IdPrendaFK", $idPrendaFK)->delete();
    }
}
