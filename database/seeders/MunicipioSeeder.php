<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("municipio")->insert([
            ['nombre' => 'Milán', 'IdDepartamentoFk' => 1],
            ['nombre' => 'Múnich', 'IdDepartamentoFk' => 2],
            ['nombre' => 'Shinjuku', 'IdDepartamentoFk' => 3],
            ['nombre' => 'Sídney', 'IdDepartamentoFk' => 4],
            ['nombre' => 'Toronto', 'IdDepartamentoFk' => 5]
        ]);
    }
}
