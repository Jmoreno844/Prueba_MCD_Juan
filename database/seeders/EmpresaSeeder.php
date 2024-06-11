<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("empresa")->insert([
            ['nit' => '900000000-6', 'razon_social' => 'Empresa de Seguridad S.A.S.', 'representante_legal' => 'Laura Martínez', 'FechaCreacion' => '2024-06-01', 'IdMunicipioFk' => 1],
            ['nit' => '900000000-7', 'razon_social' => 'Empresa de Tecnología S.A.S.', 'representante_legal' => 'Ricardo Ramírez', 'FechaCreacion' => '2024-07-02', 'IdMunicipioFk' => 2],
            ['nit' => '900000000-8', 'razon_social' => 'Empresa de Moda S.A.S.', 'representante_legal' => 'Julieta Fernández', 'FechaCreacion' => '2024-08-03', 'IdMunicipioFk' => 3],
            ['nit' => '900000000-9', 'razon_social' => 'Empresa de Construcción S.A.S.', 'representante_legal' => 'Federico Torres', 'FechaCreacion' => '2024-09-04', 'IdMunicipioFk' => 4],
            ['nit' => '900000000-10', 'razon_social' => 'Empresa de Alimentos S.A.S.', 'representante_legal' => 'Gabriela Muñoz', 'FechaCreacion' => '2024-10-05', 'IdMunicipioFk' => 5]
        ]);
    }
}
