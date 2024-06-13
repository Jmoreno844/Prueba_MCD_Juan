<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\ColorController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class ColorControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_colors()
    {
        $response = $this->getJson(route('color.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_color()
    {
        $data = [
            'Descripcion' => 'Naranja',
        ];

        $response = $this->postJson(route('color.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_color()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('color.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_color()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'Descripcion' => 'Naranja',
        ];

        $response = $this->putJson(route('color.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_color()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;


        DB::table('detalle_orden')->where('IdColorFK', $id)->update(['IdColorFK' => $newId]);
        DB::table('detalle_orden')->where('IdColorFK', $id)->update(['IdColorFK' => $newId]);
        $response = $this->deleteJson(route('color.destroy', $id));

        $response->assertStatus(200);
    }
}

