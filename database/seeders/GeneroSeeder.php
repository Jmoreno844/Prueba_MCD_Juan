<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("genero")->insert([
            ['descripcion' => 'Hombre'],
            ['descripcion' => 'Mujer'],
            ['descripcion' => 'Otro']
        ]);
    }
}
