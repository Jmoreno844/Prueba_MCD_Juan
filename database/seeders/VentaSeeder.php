<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("venta")->insert([
            ['Fecha' => '2024-01-15', 'IdEmpleadoFk' => 1, 'IdClienteFk' => 1, 'IdFormaPagoFk' => 1],
            ['Fecha' => '2024-02-10', 'IdEmpleadoFk' => 2, 'IdClienteFk' => 2, 'IdFormaPagoFk' => 2],
            ['Fecha' => '2024-03-05', 'IdEmpleadoFk' => 3, 'IdClienteFk' => 3, 'IdFormaPagoFk' => 3],
            ['Fecha' => '2024-04-20', 'IdEmpleadoFk' => 1, 'IdClienteFk' => 4, 'IdFormaPagoFk' => 4],
            ['Fecha' => '2024-05-30', 'IdEmpleadoFk' => 2, 'IdClienteFk' => 5, 'IdFormaPagoFk' => 5]
        ]);
    }
}
