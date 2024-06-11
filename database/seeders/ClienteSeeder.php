<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("cliente")->insert([
            ['nombre' => 'Laura Martínez', 'IdCliente' => '1020304050', 'IdTipoPersonaFk' => 1, 'fechaRegistro' => '2024-01-15', 'IdMunicipioFk' => 1],
            ['nombre' => 'Ricardo Ramírez', 'IdCliente' => '1234509876', 'IdTipoPersonaFk' => 2, 'fechaRegistro' => '2024-02-10', 'IdMunicipioFk' => 2],
            ['nombre' => 'Julieta Fernández', 'IdCliente' => '1122334455', 'IdTipoPersonaFk' => 3, 'fechaRegistro' => '2024-03-05', 'IdMunicipioFk' => 3],
            ['nombre' => 'Federico Torres', 'IdCliente' => '9988776655', 'IdTipoPersonaFk' => 1, 'fechaRegistro' => '2024-04-20', 'IdMunicipioFk' => 4],
            ['nombre' => 'Gabriela Muñoz', 'IdCliente' => '5566778899', 'IdTipoPersonaFk' => 2, 'fechaRegistro' => '2024-05-30', 'IdMunicipioFk' => 5]
        ]);
    }
}
