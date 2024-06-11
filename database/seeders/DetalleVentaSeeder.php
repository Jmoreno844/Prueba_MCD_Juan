<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("detalle_venta")->insert([
            ['IdVentaFk' => 1, 'IdInventarioFK' => 1, 'cantidad' => 3,],
            ['IdVentaFk' => 2, 'IdInventarioFK' => 2, 'cantidad' => 2,],
            ['IdVentaFk' => 3, 'IdInventarioFK' => 3, 'cantidad' => 4,],
            ['IdVentaFk' => 4, 'IdInventarioFK' => 4, 'cantidad' => 1,],
            ['IdVentaFk' => 5, 'IdInventarioFK' => 5, 'cantidad' => 2,]
        ]);
    }
}
