<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\PaisController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class PaisControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_paiss()
    {
        $response = $this->getJson(route('pais.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_pais()
    {
        $data = [
            'nombre' => 'Francia'
        ];

        $response = $this->postJson(route('pais.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_pais()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('pais.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_pais()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'nombre' => 'Francia'
        ];

        $response = $this->putJson(route('pais.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_pais()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;


        DB::table('departamento')->where('IdPaisFK', $id)->update(['IdPaisFK' => $newId]);
        $response = $this->deleteJson(route('pais.destroy', $id));

        $response->assertStatus(200);
    }
}

