<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("estado")->insert([
            ['descripcion' => 'Retenido', 'IdTipoEstadoFk' => 1],
            ['descripcion' => 'En revisión', 'IdTipoEstadoFk' => 2],
            ['descripcion' => 'Aprobado', 'IdTipoEstadoFk' => 3],
            ['descripcion' => 'Rechazado', 'IdTipoEstadoFk' => 4],
            ['descripcion' => 'Completado', 'IdTipoEstadoFk' => 5]
        ]);
    }
}
