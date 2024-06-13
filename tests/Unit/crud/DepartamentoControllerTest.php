<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\DepartamentoController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class DepartamentoControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_departamentos()
    {
        $response = $this->getJson(route('departamento.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_departamento()
    {
        $data = [
            'nombre' => 'Lombardía',
            'IdPaisFK' => 1,
       ];

        $response = $this->postJson(route('departamento.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_departamento()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('departamento.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_departamento()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'nombre' => 'Lombardía',
            'IdPaisFK' => 1,
        ];

        $response = $this->putJson(route('departamento.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_departamento()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;

        DB::table('municipio')->where('idDepartamentoFK', $id)->update(['idDepartamentoFK' => $newId]);
        $response = $this->deleteJson(route('departamento.destroy', $id));

        $response->assertStatus(200);
    }
}

