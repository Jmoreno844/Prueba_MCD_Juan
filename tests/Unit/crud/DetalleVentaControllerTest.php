<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\DetalleVentaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class DetalleVentaControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_detalleventas()
    {
        $response = $this->getJson(route('detalleVenta.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_detalleventa()
    {
        $data = [
            'IdVentaFk' => 1,
            'IdInventarioFK' => 1,
            'cantidad' => 3,
        ];

        $response = $this->postJson(route('detalleVenta.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_detalleventa()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('detalleVenta.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_detalleventa()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'IdVentaFk' => 1,
            'IdInventarioFK' => 1,
            'cantidad' => 3,
        ];

        $response = $this->putJson(route('detalleVenta.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_detalleventa()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar

        $response = $this->deleteJson(route('detalleVenta.destroy', $id));

        $response->assertStatus(200);
    }
}

