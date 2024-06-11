<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("orden")->insert([
            ['fecha' => '2024-01-15', 'IdEmpleadoFK' => 1, 'IdClienteFK' => 1, 'IdEstadoFK' => 1],
            ['fecha' => '2024-02-10', 'IdEmpleadoFK' => 2, 'IdClienteFk' => 2, 'IdEstadoFK' => 2],
            ['fecha' => '2024-03-05', 'IdEmpleadoFK' => 3, 'IdClienteFk' => 3, 'IdEstadoFK' => 3],
            ['fecha' => '2024-04-20', 'IdEmpleadoFK' => 1, 'IdClienteFk' => 4, 'IdEstadoFK' => 4],
            ['fecha' => '2024-05-30', 'IdEmpleadoFK' => 2, 'IdClienteFk' => 5, 'IdEstadoFK' => 5]
        ]);
    }
}
