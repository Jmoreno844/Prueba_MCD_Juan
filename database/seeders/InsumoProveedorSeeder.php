<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsumoProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("insumo_proveedor")->insert([
            ['IdInsumoFk' => 1, 'IdProveedorFk' => 6],
            ['IdInsumoFk' => 2, 'IdProveedorFk' => 7],
            ['IdInsumoFk' => 3, 'IdProveedorFk' => 8],
            ['IdInsumoFk' => 4, 'IdProveedorFk' => 9],
            ['IdInsumoFk' => 5, 'IdProveedorFk' => 10]
        ]);
    }
}
