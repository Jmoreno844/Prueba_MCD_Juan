<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\MunicipioController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class MunicipioControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_municipios()
    {
        $response = $this->getJson(route('municipio.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_municipio()
    {
        $data = [
            'nombre' => 'New City',
            'idDepartamentoFK' => 5
        ];

        $response = $this->postJson(route('municipio.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_municipio()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('municipio.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_municipio()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'nombre' => 'New City',
            'idDepartamentoFK' => 5
        ];


        $response = $this->putJson(route('municipio.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_municipio()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;


        DB::table('empresa')->where('IdMunicipioFK', $id)->update(['IdMunicipioFK' => $newId]);
        DB::table('empleado')->where('IdMunicipioFK', $id)->update(['IdMunicipioFK' => $newId]);
        DB::table('cliente')->where('IdMunicipioFK', $id)->update(['IdMunicipioFK' => $newId]);
        DB::table('proveedor')->where('IdMunicipioFK', $id)->update(['IdMunicipioFK' => $newId]);
        $response = $this->deleteJson(route('municipio.destroy', $id));

        $response->assertStatus(200);
    }
}

