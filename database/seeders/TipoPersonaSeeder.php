<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    DB::table("tipo_persona")->insert([
    ['Nombre' => 'Distribuidor'],
    ['Nombre' => 'Socio'],
    ['Nombre' => 'Consultor']
    ]);
    }
}
