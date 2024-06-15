<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\ProveedorController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class ProveedorControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_proveedors()
    {
        $response = $this->getJson(route('proveedor.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_proveedor()
    {
        $data = [
            'NitProovedor' => '900000000-6',
            'Nombre' => 'Proveedor 6',
            'IdTipoPersona' => 1,
            'IdMunicipioFK' => 1
        ];

        $response = $this->postJson(route('proveedor.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_proveedor()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('proveedor.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_proveedor()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'NitProovedor' => '900000000-6',
            'Nombre' => 'Proveedor 6',
            'IdTipoPersona' => 1,
            'IdMunicipioFK' => 1
        ];

        $response = $this->putJson(route('proveedor.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_proveedor()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar

        $response = $this->deleteJson(route('proveedor.destroy', $id));

        $response->assertStatus(200);
    }
}

