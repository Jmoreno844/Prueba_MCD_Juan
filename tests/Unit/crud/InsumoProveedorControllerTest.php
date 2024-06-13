<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\InsumoProveedorController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;

class InsumoProveedorControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');
    }

    /** @test */
    public function it_can_list_all_insumoproveedors()
    {
        $response = $this->getJson(route('insumoProveedor.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_insumoproveedor()
    {
        $idInsumoFK = 1;
        $idProveedorFK = 7;

        $response = $this->postJson(route('insumoProveedor.store', ['idInsumoFK' => $idInsumoFK, 'idProveedorFK' => $idProveedorFK]));

        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_show_a_insumoproveedor()
    {
        $idInsumoFK = 1;
        $idProveedorFK = 6;

        $response = $this->getJson(route('insumoProveedor.show', ['idInsumoFK' => $idInsumoFK, 'idProveedorFK' => $idProveedorFK]));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_insumoproveedor()
    {
        $idInsumoFK = 1;
        $idProveedorFK = 6;

        $response = $this->deleteJson(route('insumoProveedor.destroy', ['idInsumoFK' => $idInsumoFK, 'idProveedorFK' => $idProveedorFK]));

        $response->assertStatus(200);
    }
}
