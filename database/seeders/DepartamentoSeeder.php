<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("departamento")->insert([
            ['nombre' => 'Lombardía', 'IdPaisFk' => 1],
            ['nombre' => 'Baviera', 'IdPaisFk' => 2],
            ['nombre' => 'Tokio', 'IdPaisFk' => 3],
            ['nombre' => 'Nueva Gales del Sur', 'IdPaisFk' => 4],
            ['nombre' => 'Ontario', 'IdPaisFk' => 5]
        ]);
    }
}
