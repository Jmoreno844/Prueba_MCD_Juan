<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\InventarioController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class InventarioControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_inventarios()
    {
        $response = $this->getJson(route('inventario.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_inventario()
    {
        $data = [
            'CodInv' => 'INV016',
            'IdPrendaFk' => 11,
            'IdTallaFK' => 1,
            'IdColorFK' => 1,
            'Cantidad' => 5
        ];

        $response = $this->postJson(route('inventario.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_inventario()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('inventario.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_inventario()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'CodInv' => 'INV016',
            'IdPrendaFk' => 11,
            'IdTallaFK' => 1,
            'IdColorFK' => 1,
            'Cantidad' => 5
        ];

        $response = $this->putJson(route('inventario.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_inventario()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;


        DB::table('detalle_venta')->where('IdInventarioFK', $id)->update(['IdInventarioFK' => $newId]);
        $response = $this->deleteJson(route('inventario.destroy', $id));

        $response->assertStatus(200);
    }
}

