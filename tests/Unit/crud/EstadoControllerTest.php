<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\EstadoController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class EstadoControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_estados()
    {
        $response = $this->getJson(route('estado.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_estado()
    {
        $data = [
            'Descripcion' => 'Retenido',
        ];

        $response = $this->postJson(route('estado.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_estado()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('estado.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_estado()
    {
        $id = 2; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'Descripcion' => 'Retenido',
        ];

        $response = $this->putJson(route('estado.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_estado()
    {
        $id = 3; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;


        DB::table('detalle_orden')->where('IdEstadoFK', $id)->update(['IdEstadoFK' => $newId]);
        DB::table('orden')->where('IdEstadoFK', $id)->update(['IdEstadoFK' => $newId]);
        $response = $this->deleteJson(route('estado.destroy', $id));

        $response->assertStatus(200);
    }
}

