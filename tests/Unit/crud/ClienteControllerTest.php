<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\ClienteController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class ClienteControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_clientes()
    {
        $response = $this->getJson(route('clientes.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_cliente()
    {
        $data = [
            'nombre' => 'Laura Martínez',
            'IdCliente' => '1020304050',
            'IdTipoPersonaFK' => 1,
            'fechaRegistro' => '2024-01-15',
            'IdMunicipioFK' => 1
        ];

        $response = $this->postJson(route('clientes.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_cliente()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('clientes.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_cliente()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'nombre' => 'Laura Martínez',
            'IdCliente' => '1020304050',
            'IdTipoPersonaFK' => 1,
            'fechaRegistro' => '2024-01-15',
            'IdMunicipioFK' => 1
        ];

        $response = $this->putJson(route('clientes.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_cliente()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newCargoId = 2;


        DB::table('orden')->where('idClienteFK', $id)->update(['idClienteFK' => $newCargoId]);
        DB::table('venta')->where('idClienteFK', $id)->update(['idClienteFK' => $newCargoId]);

        $response = $this->deleteJson(route('clientes.destroy', $id));

        $response->assertStatus(200);
    }
}

