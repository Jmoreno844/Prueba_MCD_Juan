<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\InsumoController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class InsumoControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_insumos()
    {
        $response = $this->getJson(route('insumo.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_insumo()
    {
        $data = [
            'nombre' => 'Hilo de algodón',
            'valor_unit' => 500,
            'stock_min' => 50,
            'stock_max' => 500,
        ];

        $response = $this->postJson(route('insumo.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_insumo()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('insumo.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_insumo()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'nombre' => 'Hilo de algodón',
            'valor_unit' => 500,
            'stock_min' => 50,
            'stock_max' => 500,
        ];

        $response = $this->putJson(route('insumo.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_insumo()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newCargoId = 2;


        DB::table('insumo_proveedor')->where('IdInsumoFk', $id)->update(['IdInsumoFk' => $newCargoId]);
        DB::table('insumo_prendas')->where('IdInsumoFk', $id)->update(['IdInsumoFk' => $newCargoId]);
        $response = $this->deleteJson(route('insumo.destroy', $id));

        $response->assertStatus(200);
    }
}

