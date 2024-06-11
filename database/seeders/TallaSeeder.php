<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

DB::table("talla")->insert([
    ['descripcion' => 'XXS - Extra extra pequeña'],
    ['descripcion' => '3XL - Triple extra grande'],
    ['descripcion' => '4XL - Cuádruple extra grande'],
    ['descripcion' => '5XL - Quíntuple extra grande'],
    ['descripcion' => '6XL - Séxtuple extra grande']
]);
    }
}
