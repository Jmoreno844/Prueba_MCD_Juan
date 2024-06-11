<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("proveedor")->insert([
            ["id" => 6,'NitProovedor' => '900000000-6', 'Nombre' => 'Proveedor 6', 'IdTipoPersona' => 1, 'IdMunicipioFk' => 1],
            ["id" => 7,'NitProovedor' => '900000000-7', 'Nombre' => 'Proveedor 7', 'IdTipoPersona' => 2, 'IdMunicipioFk' => 2],
            ["id" => 8,'NitProovedor' => '900000000-8', 'Nombre' => 'Proveedor 8', 'IdTipoPersona' => 3, 'IdMunicipioFk' => 3],
            ["id" => 9,'NitProovedor' => '900000000-9', 'Nombre' => 'Proveedor 9', 'IdTipoPersona' => 1, 'IdMunicipioFk' => 4],
            ["id" => 10,'NitProovedor' => '900000000-10', 'Nombre' => 'Proveedor 10', 'IdTipoPersona' => 2, 'IdMunicipioFk' => 5]
        ]);
    }
}
