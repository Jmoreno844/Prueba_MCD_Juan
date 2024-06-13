<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\VentaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class VentaControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_ventas()
    {
        $response = $this->getJson(route('venta.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_venta()
    {
        $data = [
            'Fecha' => '2024-01-15',
            'IdEmpleadoFK' => 1,
            'IdClienteFK' => 1,
            'IdFormaPagoFK' => 1
        ];

        $response = $this->postJson(route('venta.store'), $data);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_show_a_venta()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('venta.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_venta()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'Fecha' => '2024-01-15',
            'IdEmpleadoFK' => 1,
            'IdClienteFK' => 1,
            'IdFormaPagoFK' => 1
        ];
        $response = $this->putJson(route('venta.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_venta()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;


        DB::table('detalle_venta')->where('IdVentaFK', $id)->update(['IdVentaFK' => $newId]);
        $response = $this->deleteJson(route('venta.destroy', $id));

        $response->assertStatus(200);
    }
}

