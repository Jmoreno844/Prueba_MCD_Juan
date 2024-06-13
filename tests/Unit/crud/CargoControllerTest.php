<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\CargoController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class CargoControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_cargos()
    {
        $response = $this->getJson(route('cargos.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_cargo()
    {
        $data = [
            'descripcion' => 'Gerente',
            'sueldo_base' => 5000000
        ];

        $response = $this->postJson(route('cargos.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_cargo()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('cargos.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_cargo()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'descripcion' => 'Gerente',
            'sueldo_base' => 5000000
        ];

        $response = $this->putJson(route('cargos.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_cargo()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newCargoId = 2; // Replace with the ID of the Cargo you want to reference

        // Update any Empleado records that reference the Cargo
        DB::table('empleado')->where('idCargoFK', $id)->update(['idCargoFK' => $newCargoId]);

        $response = $this->deleteJson(route('cargos.destroy', $id));

        $response->assertStatus(200);
    }
}

