<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\OrdenController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class OrdenControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_ordens()
    {
        $response = $this->getJson(route('orden.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_orden()
    {
        $data = [
            "fecha" => "2021-09-01",
            'IdEmpleadoFK' => '1',
            'IdClienteFK' => '1',
            'IdEstadoFK' => '1'
        ];

        $response = $this->postJson(route('orden.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_orden()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('orden.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_orden()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            "fecha" => "2021-10-01",
            'IdEmpleadoFK' => '2',
            'IdClienteFK' => '2',
            'IdEstadoFK' => '2'
        ];

        $response = $this->putJson(route('orden.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_orden()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $id_nuevo = 2;

        DB::table("detalle_orden")->where("IdOrdenFK", $id)->update(["IdOrdenFK" => $id_nuevo]);
        $response = $this->deleteJson(route('orden.destroy', $id));

        $response->assertStatus(200);
    }
}

