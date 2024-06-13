#!/bin/bash



# Lista de controladores
controllers=("Color" "Departamento" "DetalleOrden" "DetalleVenta" "Empleado" "Empresa" "Estado" "FormaPago" "Genero" "Insumo" "InsumoPrendas" "InsumoProveedor" "Inventario" "Municipio" "Orden" "Pais" "Prenda" "Proveedor" "Talla" "TipoPersona" "TipoProteccion" "Venta")

# Crear tests para cada controlador
for controller in "${controllers[@]}"
do
    # Nombre del controlador en minúsculas
    controller_lowercase=$(echo "${controller}" | awk '{print tolower($0)}')

    # Generar archivo de test
    cat <<EOL > tests/Unit/crud/${controller}ControllerTest.php
<?php

namespace Tests\Unit\crud;

use App\Http\Controllers\Api\v1\crud\\${controller}Controller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use DB;
class ${controller}ControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        // seed the database
        \$this->artisan('db:seed');
       
    }
    /** @test */
    public function it_can_list_all_${controller_lowercase}s()
    {
        \$response = \$this->getJson(route('${controller_lowercase}.index'));

        \$response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_${controller_lowercase}()
    {
        \$data = [
            // Reemplazar con los campos necesarios para la creación
            'field1' => 'value1',
            'field2' => 'value2',
            // Agregar más campos según sea necesario
        ];

        \$response = \$this->postJson(route('${controller_lowercase}.store'), \$data);

        \$response->assertStatus(200); 
    }

    /** @test */
    public function it_can_show_a_${controller_lowercase}()
    {
        \$id = 1; // Reemplazar con el ID del registro que deseas mostrar

        \$response = \$this->getJson(route('${controller_lowercase}.show', \$id));

        \$response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_${controller_lowercase}()
    {
        \$id = 1; // Reemplazar con el ID del registro que deseas actualizar

        \$data = [
            // Reemplazar con los campos necesarios para la actualización
            'field1' => 'updated_value1',
            'field2' => 'updated_value2',
            // Agregar más campos según sea necesario
        ];

        \$response = \$this->putJson(route('${controller_lowercase}.update', \$id), \$data);

        \$response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_${controller_lowercase}()
    {
        \$id = 1; // Reemplazar con el ID del registro que deseas eliminar

        \$response = \$this->deleteJson(route('${controller_lowercase}.destroy', \$id));

        \$response->assertStatus(200); 
    }
}

EOL
done

# Ejecutar tests
php artisan test --testsuite Unit
