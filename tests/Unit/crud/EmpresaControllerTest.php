<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\EmpresaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class EmpresaControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_empresas()
    {
        $response = $this->getJson(route('empresa.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_empresa()
    {
        $data = [
            'nit' => '900000000-1',
            'razon_social' => 'Nombre de la Empresa',
            'representante_legal' => 'Nombre del Representante Legal',
            'FechaCreacion' => '2022-01-01',
            'IdMunicipioFk' => 1];

        $response = $this->postJson(route('empresa.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_empresa()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('empresa.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_empresa()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'nit' => '900000000-1',
            'razon_social' => 'Nombre de la Empresa',
            'representante_legal' => 'Nombre del Representante Legal',
            'FechaCreacion' => '2022-01-01',
            'IdMunicipioFk' => 1];


        $response = $this->putJson(route('empresa.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_empresa()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar

        $response = $this->deleteJson(route('empresa.destroy', $id));

        $response->assertStatus(200);
    }
}

