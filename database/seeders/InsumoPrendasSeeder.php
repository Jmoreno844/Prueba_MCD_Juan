<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsumoPrendasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

DB::table("insumo_prendas")->insert([
    ['IdInsumoFk' => 1, 'IdPrendaFk' => 11, 'Cantidad' => 3],
    ['IdInsumoFk' => 2, 'IdPrendaFk' => 12, 'Cantidad' => 2],
    ['IdInsumoFk' => 3, 'IdPrendaFk' => 13, 'Cantidad' => 1],
    ['IdInsumoFk' => 4, 'IdPrendaFk' => 14, 'Cantidad' => 4],
    ['IdInsumoFk' => 5, 'IdPrendaFk' => 15, 'Cantidad' => 2]
]);
    }
}
