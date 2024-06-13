<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\DetalleOrdenController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class DetalleOrdenControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_detalleordens()
    {
        $response = $this->getJson(route('detalleOrden.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_detalleorden()
    {
        $data = [
            'IdOrdenFk' => 1,
            'IdPrendaFk' => 11,
            'PrendaId' => 1,
            'IdTallaFK' => 1,
            'cantidad_producir' => 20,
            'IdColorFK' => 1,
            'cantidad_producida' => 15,
            'IdEstadoFk' => 1,
        ];

        $response = $this->postJson(route('detalleOrden.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_detalleorden()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('detalleOrden.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_detalleorden()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'IdOrdenFk' => 1,
            'IdPrendaFk' => 11,
            'PrendaId' => 1,
            'IdTallaFK' => 1,
            'cantidad_producir' => 20,
            'IdColorFK' => 1,
            'cantidad_producida' => 15,
            'IdEstadoFk' => 1,
        ];

        $response = $this->putJson(route('detalleOrden.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_detalleorden()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar

        $response = $this->deleteJson(route('detalleOrden.destroy', $id));

        $response->assertStatus(200);
    }
}

