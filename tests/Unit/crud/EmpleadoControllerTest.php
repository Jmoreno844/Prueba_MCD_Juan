<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\EmpleadoController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class EmpleadoControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        $this->artisan('db:seed');

    }
    /** @test */
    public function it_can_list_all_empleados()
    {
        $response = $this->getJson(route('empleado.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_empleado()
    {
        $data = [
            'nombre' => 'Nombre del Empleado',
            'idCargoFK' => 1, // Asegúrate de que este ID exista en la tabla de Cargos
            'fecha_ingreso' => '2022-01-01',
            'IdMunicipioFK' => 1, // Asegúrate de que este ID exista en la tabla de Municipios
        ];

        $response = $this->postJson(route('empleado.store'), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_show_a_empleado()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas mostrar

        $response = $this->getJson(route('empleado.show', $id));

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_empleado()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas actualizar

        $data = [
            'nombre' => 'Nombre del Empleado',
            'idCargoFK' => 1, // Asegúrate de que este ID exista en la tabla de Cargos
            'fecha_ingreso' => '2022-01-01',
            'IdMunicipioFK' => 1, // Asegúrate de que este ID exista en la tabla de Municipios
        ];
        $response = $this->putJson(route('empleado.update', $id), $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_empleado()
    {
        $id = 1; // Reemplazar con el ID del registro que deseas eliminar
        $newId = 2;

        DB::table('orden')->where('IdEmpleadoFK', $id)->update(['IdEmpleadoFK' => $newId]);
        DB::table('venta')->where('IdEmpleadoFK', $id)->update(['IdEmpleadoFK' => $newId]);
        $response = $this->deleteJson(route('empleado.destroy', $id));

        $response->assertStatus(200);
    }
}

