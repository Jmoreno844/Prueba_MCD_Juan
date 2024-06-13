<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\FormaPagoController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class FormaPagoControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_formapagos()
    {
        $response = $this->getJson(route('formaPago.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_formapago()
    {
        $data = [
            'Descripcion' => 'Bitcoin',
        ];

        $response = $this->postJson(route('formaPago.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_formapago()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('formaPago.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_formapago()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'Descripcion' => 'Bitcoin',
        ];

        $response = $this->putJson(route('formaPago.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_formapago()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;


        DB::table('venta')->where('IdFormaPagoFk', $id)->update(['IdFormaPagoFk' => $newId]);
        $response = $this->deleteJson(route('formaPago.destroy', $id));

        $response->assertStatus(200);
    }
}

