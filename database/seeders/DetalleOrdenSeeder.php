<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleOrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("detalle_orden")->insert([
            ['IdOrdenFk' => 1, 'IdPrendaFk' => 11, 'PrendaId' => 1,"IdTallaFK" => 1 , 'cantidad_producir' => 20, 'IdColorFk' => 1, 'cantidad_producida' => 15, 'IdEstadoFk' => 1],
            ['IdOrdenFk' => 2, 'IdPrendaFk' => 12, 'PrendaId' => 2,"IdTallaFK" => 1 , 'cantidad_producir' => 10, 'IdColorFk' => 2, 'cantidad_producida' => 7, 'IdEstadoFk' => 2],
            ['IdOrdenFk' => 3, 'IdPrendaFk' => 13, 'PrendaId' => 3,"IdTallaFK" => 1 , 'cantidad_producir' => 5, 'IdColorFk' => 3, 'cantidad_producida' => 4, 'IdEstadoFk' => 3],
            ['IdOrdenFk' => 4, 'IdPrendaFk' => 14, 'PrendaId' => 4,"IdTallaFK" => 1 , 'cantidad_producir' => 3, 'IdColorFk' => 4, 'cantidad_producida' => 3, 'IdEstadoFk' => 4],
            ['IdOrdenFk' => 5, 'IdPrendaFk' => 15, 'PrendaId' => 5,"IdTallaFK" => 1 , 'cantidad_producir' => 2, 'IdColorFk' => 5, 'cantidad_producida' => 2, 'IdEstadoFk' => 5]
        ]);
    }
}
