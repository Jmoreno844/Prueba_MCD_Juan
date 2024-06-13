<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\TipoProteccionController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class TipoProteccionControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_tipoproteccions()
    {
        $response = $this->getJson(route('tipoProteccion.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_tipoproteccion()
    {
        $data = [
            'Descripcion' => 'Protección UV'
        ];

        $response = $this->postJson(route('tipoProteccion.store'), $data);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_show_a_tipoproteccion()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('tipoProteccion.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_tipoproteccion()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'Descripcion' => 'Protección UV'
        ];

        $response = $this->putJson(route('tipoProteccion.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_tipoproteccion()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;

        DB::table('prenda')->where('IdTipoProteccionFK', $id)->update(['IdTipoProteccionFK' => $newId]);
        $response = $this->deleteJson(route('tipoProteccion.destroy', $id));

        $response->assertStatus(200);
    }
}

