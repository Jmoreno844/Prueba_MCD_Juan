<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("inventario")->insert([
            ['CodInv' => 'INV011', 'IdPrendaFk' => 11, 'IdTallaFK' => 1, 'IdColorFK' => 1, "Cantidad" => 3],
            ['CodInv' => 'INV012', 'IdPrendaFk' => 12, 'IdTallaFK' => 2, 'IdColorFK' => 2, "Cantidad" => 2],
            ['CodInv' => 'INV013', 'IdPrendaFk' => 13, 'IdTallaFK' => 3, 'IdColorFK' => 3, "Cantidad" => 4],
            ['CodInv' => 'INV014', 'IdPrendaFk' => 14, 'IdTallaFK' => 4, 'IdColorFK' => 4, "Cantidad" => 1],
            ['CodInv' => 'INV015', 'IdPrendaFk' => 15, 'IdTallaFK' => 5, 'IdColorFK' => 5, "Cantidad" => 2]
        ]);
    }
}
