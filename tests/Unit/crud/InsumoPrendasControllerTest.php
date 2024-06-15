<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\InsumoPrendasController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;

class InsumoPrendasControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');
    }

    /** @test */
    public function it_can_list_all_insumoprendass()
    {
        $response = $this->getJson(route('insumoPrendas.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_insumoprendas()
    {
        $idInsumoFK = 1;
        $idPrendaFK = 12;
        $data = [
            'Cantidad' => 3,
        ];

        $response = $this->postJson(route('insumoPrendas.store', ['idInsumoFK' => $idInsumoFK, 'idPrendaFK' => $idPrendaFK]), $data);



        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_insumoprendas()
    {
        $idInsumoFK = 1;
        $idPrendaFK = 11;
        $response = $this->getJson(route('insumoPrendas.show', ['idInsumoFK' => $idInsumoFK, 'idPrendaFK' => $idPrendaFK]));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_insumoprendas()
    {
        $idInsumoFK = 2;
        $idPrendaFK = 12;
        $data = [
            'Cantidad' => 5,
        ];

        $response = $this->putJson(route('insumoPrendas.update', ['idInsumoFK' => $idInsumoFK, 'idPrendaFK' => $idPrendaFK]), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_insumoprendas()
    {
        $idInsumoFK = 1;
        $idPrendaFK = 11;
        $response = $this->deleteJson(route('insumoPrendas.destroy', ['idInsumoFK' => $idInsumoFK, 'idPrendaFK' => $idPrendaFK]));

        $response->assertStatus(200);
    }
}
