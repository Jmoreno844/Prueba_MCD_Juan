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
            // Reemplazar con los campos necesarios para la creación
            'field1' => 'value1',
            'field2' => 'value2',
            // Agregar más campos según sea necesario
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
            // Reemplazar con los campos necesarios para la actualización
            'field1' => 'updated_value1',
            'field2' => 'updated_value2',
            // Agregar más campos según sea necesario
        ];

        $response = $this->putJson(route('orden.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_orden()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar

        $response = $this->deleteJson(route('orden.destroy', $id));

        $response->assertStatus(200); 
    }
}

