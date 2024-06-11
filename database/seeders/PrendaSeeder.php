<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("prenda")->insert([
            ["id" => 11, 'Nombre' => 'Chaleco reflectante', 'ValorUnitCop' => 25000, 'ValorUnitUsd' => 6.25, 'IdEstadoFk' => 1, 'IdTipoProteccionFK' => 1, 'IdGeneroFk' => 2, 'Codigo' => 'PR011'],
            ["id" => 12, 'Nombre' => 'Sombrero de paja', 'ValorUnitCop' => 15000, 'ValorUnitUsd' => 3.75, 'IdEstadoFk' => 1, 'IdTipoProteccionFK' => 2, 'IdGeneroFk' => 1, 'Codigo' => 'PR012'],
            ["id" => 13, 'Nombre' => 'Guantes de lana', 'ValorUnitCop' => 20000, 'ValorUnitUsd' => 5, 'IdEstadoFk' => 1, 'IdTipoProteccionFK' => 3, 'IdGeneroFk' => 3, 'Codigo' => 'PR013'],
            ["id" => 14, 'Nombre' => 'Abrigo de invierno', 'ValorUnitCop' => 80000, 'ValorUnitUsd' => 20, 'IdEstadoFk' => 1, 'IdTipoProteccionFK' => 4, 'IdGeneroFk' => 2, 'Codigo' => 'PR014'],
            ["id" => 15, 'Nombre' => 'Pantalones térmicos', 'ValorUnitCop' => 50000, 'ValorUnitUsd' => 12.5, 'IdEstadoFk' => 1, 'IdTipoProteccionFK' => 5, 'IdGeneroFk' => 1, 'Codigo' => 'PR015']
        ]);
    }
}
