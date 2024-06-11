<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("forma_pago")->insert([
            ['descripcion' => 'Bitcoin'],
            ['descripcion' => 'Cheque'],
            ['descripcion' => 'Pago móvil'],
            ['descripcion' => 'Crédito en tienda'],
            ['descripcion' => 'Apple Pay']
        ]);
    }
}
