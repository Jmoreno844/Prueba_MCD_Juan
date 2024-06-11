<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("tipo_estado")->insert([
            ['descripcion' => 'Cancelado'],
            ['descripcion' => 'Devuelto'],
            ['descripcion' => 'Reembolsado'],
            ['descripcion' => 'Pendiente de pago'],
            ['descripcion' => 'Pago rechazado']
        ]);


    }
}
