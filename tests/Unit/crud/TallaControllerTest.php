<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\TallaController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class TallaControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_tallas()
    {
        $response = $this->getJson(route('talla.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_talla()
    {
        $data = [
            'Descripcion' => 'XXS - Extra extra pequeña'
        ];

        $response = $this->postJson(route('talla.store'), $data);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_show_a_talla()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('talla.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_talla()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'Descripcion' => 'XXS - Extra extra pequeña'
        ];

        $response = $this->putJson(route('talla.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_talla()
    {
        $id = 2;
        $newId = 1;

        DB::table('detalle_orden')->where('IdTallaFK', $id)->update(['IdTallaFK' => $newId]);
        DB::table('inventario')->where('IdTallaFK', $id)->update(['IdTallaFK' => $newId]);
        $response = $this->deleteJson(route('talla.destroy', $id));

        $response->assertStatus(200);
    }
}

