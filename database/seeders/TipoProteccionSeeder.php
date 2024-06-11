<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoProteccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("tipo_proteccion")->insert([
            ['descripcion' => 'Protección UV'],
            ['descripcion' => 'Protección química'],
            ['descripcion' => 'Protección contra radiación'],
            ['descripcion' => 'Protección térmica'],
            ['descripcion' => 'Protección eléctrica']
        ]);
    }
}
