<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("empleado")->insert([
            ['nombre' => 'Laura Martínez', 'IdCargoFk' => 1, 'fecha_ingreso' => '2022-01-15', 'IdMunicipioFk' => 1],
            ['nombre' => 'Ricardo Ramírez', 'IdCargoFk' => 2, 'fecha_ingreso' => '2024-02-10', 'IdMunicipioFk' => 2],
            ['nombre' => 'Julieta Fernández', 'IdCargoFk' => 3, 'fecha_ingreso' => '2024-03-05', 'IdMunicipioFk' => 3],
            ['nombre' => 'Federico Torres', 'IdCargoFk' => 1, 'fecha_ingreso' => '2024-04-20', 'IdMunicipioFk' => 4],
            ['nombre' => 'Gabriela Muñoz', 'IdCargoFk' => 2, 'fecha_ingreso' => '2024-05-30', 'IdMunicipioFk' => 5]
        ]);
    }
}
