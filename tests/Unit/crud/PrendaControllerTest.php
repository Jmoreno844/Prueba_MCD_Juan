<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\PrendaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class PrendaControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_prendas()
    {
        $response = $this->getJson(route('prenda.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_prenda()
    {
        $data = [
            'Nombre' => 'Camiseta de algodón',
            'ValorUnitCop' => 30000,
            'ValorUnitUsd' => 7.5,
            'IdEstadoFK' => 1,
            'IdTipoProteccionFK' => 1,
            'IdGeneroFK' => 1,
            'Codigo' => 'PR011'
        ];

        $response = $this->postJson(route('prenda.store'), $data);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_show_a_prenda()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('prenda.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_prenda()
    {
        $id = 12; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'Nombre' => 'Camiseta',
            'ValorUnitCop' => 30000,
            'ValorUnitUsd' => 7.5,
            'IdEstadoFK' => 1,
            'IdTipoProteccionFK' => 1,
            'IdGeneroFK' => 1,
            'Codigo' => 'PR011'
        ];

        $response = $this->putJson(route('prenda.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_prenda()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar

        $response = $this->deleteJson(route('prenda.destroy', $id));

        $response->assertStatus(200);
    }
}

