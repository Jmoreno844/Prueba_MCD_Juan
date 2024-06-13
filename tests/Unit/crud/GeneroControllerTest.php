<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\GeneroController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class GeneroControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_generos()
    {
        $response = $this->getJson(route('genero.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_genero()
    {
        $data = [
            'descripcion' => 'No Binario',
        ];

        $response = $this->postJson(route('genero.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_genero()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('genero.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_genero()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'descripcion' => 'No Binario',
        ];

        $response = $this->putJson(route('genero.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_genero()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;


        DB::table('prenda')->where('IdGeneroFk', $id)->update(['IdGeneroFk' => $newId]);
        $response = $this->deleteJson(route('genero.destroy', $id));

        $response->assertStatus(200);
    }
}

