<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("insumo")->insert([
            ['nombre' => 'Tela de lana', 'valor_unit' => 15000, 'stock_min' => 80, 'stock_max' => 800],
            ['nombre' => 'Elástico', 'valor_unit' => 1000, 'stock_min' => 30, 'stock_max' => 300],
            ['nombre' => 'Cinta', 'valor_unit' => 2000, 'stock_min' => 40, 'stock_max' => 400],
            ['nombre' => 'Encaje', 'valor_unit' => 2500, 'stock_min' => 25, 'stock_max' => 250],
            ['nombre' => 'Tela impermeable', 'valor_unit' => 30000, 'stock_min' => 10, 'stock_max' => 100]
        ]);
    }
}
