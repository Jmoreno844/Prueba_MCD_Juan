<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConsultasControllerTest extends TestCase
{

    /** @test */
    public function it_can_fetch_clientes_en_compra_fecha_especifica()
    {
        $response = $this->getJson(route('clientesEnCompraFechaEspecifica', ['fecha' => '2023-07-01']));
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_ventas_julio_2023()
    {
        $response = $this->getJson('/api/ventas-julio-2023');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_empleados_con_cargos_y_municipios()
    {
        $response = $this->getJson('/api/empleados-con-cargos-y-municipios');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_ventas_con_clientes_y_forma_pago()
    {
        $response = $this->getJson('/api/ventas-con-clientes-y-forma-pago');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_ordenes_con_detalles()
    {
        $response = $this->getJson('/api/ordenes-con-detalles');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_inventario_con_detalles()
    {
        $response = $this->getJson('/api/inventario-con-detalles');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_proovedores_con_insumos()
    {
        $response = $this->getJson('/api/proovedores-con-insumos');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_cantidad_ventas_por_empleado()
    {
        $response = $this->getJson('/api/cantidad-ventas-por-empleado');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_ordenes_en_proceso()
    {
        $response = $this->getJson('/api/ordenes-en-proceso');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_empresa_y_municipio()
    {
        $response = $this->getJson('/api/empresa-y-municipio');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_empleados_duracion_empleo()
    {
        $response = $this->getJson('/api/empleados-duracion-empleo');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_valor_total_ventas_por_prenda_usd()
    {
        $response = $this->getJson('/api/valor-total-ventas-por-prenda-usd');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_cantidades_max_y_min_fabricacion_de_insumo_por_prendas()
    {
        $response = $this->getJson('/api/cantidades-max-y-min-fabricacion-de-insumo-por-prendas');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_stock_prendas()
    {
        $response = $this->getJson('/api/stock-prendas');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_ventas_rango_fechas()
    {
        $response = $this->getJson('/api/ventas-rango-fechas/2023-01-01/2023-12-31');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_prendas_con_estado()
    {
        $response = $this->getJson('/api/prendas-con-estado');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_empleados_por_fecha_ingreso()
    {
        $response = $this->getJson('/api/empleados-por-fecha-ingreso');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_tipo_proteccion_con_su_cantidad_prendas()
    {
        $response = $this->getJson('/api/tipo-proteccion-con-su-cantidad-prendas');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_estado_con_cantidad_prendas()
    {
        $response = $this->getJson('/api/estado-con-cantidad-prendas');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_prenda_junto_valor_total_ventas_cop()
    {
        $response = $this->getJson('/api/prenda-junto-valor-total-ventas-cop');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }

    /** @test */
    public function it_can_fetch_total_gastado_por_cliente()
    {
        $response = $this->getJson('/api/total-gastado-por-cliente');
        $response->assertStatus(200);
        $response->assertJsonStructure(['data', 'links']);
    }
}
