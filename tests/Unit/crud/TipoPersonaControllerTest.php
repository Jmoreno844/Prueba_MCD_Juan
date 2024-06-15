<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\TipoPersonaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class TipoPersonaControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_tipopersonas()
    {
        $response = $this->getJson(route('tipoPersona.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_tipopersona()
    {
        $data = [
            'nombre' => 'Distribuidor'
        ];

        $response = $this->postJson(route('tipoPersona.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_tipopersona()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('tipoPersona.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_tipopersona()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'nombre' => 'Distribuidor'
        ];

        $response = $this->putJson(route('tipoPersona.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_tipopersona()
    {
        $id = 1;
        $newId = 2;


        DB::table('cliente')->where('IdTipoPersonaFK', $id)->update(['IdTipoPersonaFK' => $newId]);
        DB::table('proveedor')->where('IdTipoPersona', $id)->update(['IdTipoPersona' => $newId]);
        $response = $this->deleteJson(route('tipoPersona.destroy', $id));

        $response->assertStatus(200);
    }
}

