<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("cargos")->insert([
            ['descripcion' => 'Gerente', 'sueldo_base' => 5000000],
            ['descripcion' => 'Supervisor', 'sueldo_base' => 4000000],
            ['descripcion' => 'Operario', 'sueldo_base' => 2000000],
            ['descripcion' => 'Recepcionista', 'sueldo_base' => 1200000],
            ['descripcion' => 'Mantenimiento', 'sueldo_base' => 900000]
        ]);
    }
}
