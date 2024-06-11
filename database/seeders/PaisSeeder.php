<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("pais")->insert([
            ['nombre' => 'Italia'],
            ['nombre' => 'Alemania'],
            ['nombre' => 'Japón'],
            ['nombre' => 'Australia'],
            ['nombre' => 'Canadá']
        ]);
    }
}
