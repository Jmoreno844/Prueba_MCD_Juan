<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PaisSeeder::class,
            DepartamentoSeeder::class,
            MunicipioSeeder::class,
            EmpresaSeeder::class,
            CargosSeeder::class,
            EmpleadoSeeder::class,
            TipoPersonaSeeder::class,
            ProveedorSeeder::class,
            ClienteSeeder::class,
            FormaPagoSeeder::class,
            VentaSeeder::class,
            TipoEstadoSeeder::class,
            EstadoSeeder::class,
            OrdenSeeder::class,
            ColorSeeder::class,
            GeneroSeeder::class,
            TipoProteccionSeeder::class,
            TallaSeeder::class,
            PrendaSeeder::class,
            DetalleOrdenSeeder::class,
            InsumoSeeder::class,
            InsumoPrendasSeeder::class,
            InventarioSeeder::class,
            InsumoProveedorSeeder::class,
            DetalleVentaSeeder::class,
        ]);    }
}
