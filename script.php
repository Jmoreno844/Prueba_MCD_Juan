<?php

$controllers = [
    'Color',
    'Departamento',
    'Empleado',
    'DetalleVenta',
    'DetalleOrden',
    'Genero',
    'FormaPago',
    'Estado',
    'Empresa',
    'InsumoProveedor',
    'InsumoPrendas',
    'Insumo',
    'Orden',
    'Municipio',
    'Inventario',
    'Prenda',
    'Pais',
    'Proveedor',
    'TipoProteccion',
    'TipoPersona',
    'Talla',
    'Venta'
];

$controllerTemplate = <<<EOT
<?php
namespace App\Http\Controllers\Api\\v1\crud;

use App\DTOs\{NAME}DTO;
use App\Http\Controllers\Api\\v1\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Services\{NAME}Service;

class {NAME}Controller extends Controller
{
    protected \${name}Service;
    protected \$fields = [{FIELDS}];

    public function __construct({NAME}Service \${name}Service)
    {
        \$this->{name}Service = \${name}Service;
    }

    public function index(Request \$request)
    {
        \$perPage = \$request->get('per_page', 15);
        \$items = \$this->{name}Service->index(\$perPage);
        return response()->json(\$items);
    }

    public function store(Request \$request)
    {
        \$validator = Validator::make(\$request->all(), [
            [VALIDATOR_RULES]
        ]);

        if (\$validator->fails()) {
            return response()->json(['message' => \$validator->errors()], 422);
        }

        try {
            \$dto = new {NAME}DTO(\$request, \$this->fields);
            \$this->{name}Service->store(\$dto);

            return response()->json(['message' => '{NAME} creado correctamente.']);
        } catch (\Exception \$e) {
            return response()->json(['message' => \$e->getMessage()], 500);
        }
    }

    public function show(\$id)
    {
        \$item = \$this->{name}Service->show(\$id);
        return response()->json(\$item);
    }

    public function update(Request \$request, \$id)
    {
        \$validator = Validator::make(\$request->all(), [
            [VALIDATOR_RULES]
        ]);

        if (\$validator->fails()) {
            return response()->json(['message' => \$validator->errors()], 422);
        }

        try {
            \$dto = new {NAME}DTO(\$request, \$this->fields);
            \$this->{name}Service->update(\$id, \$dto);

            return response()->json(['message' => '{NAME} actualizado correctamente.']);
        } catch (\Exception \$e) {
            return response()->json(['message' => \$e->getMessage()], 500);
        }
    }

    public function destroy(\$id)
    {
        try {
            \$this->{name}Service->destroy(\$id);

            return response()->json(['message' => '{NAME} eliminado.']);
        } catch (\Exception \$e) {
            return response()->json(['message' => \$e->getMessage()], 500);
        }
    }
}
EOT;

$validators = [
    'Color' => [
        'fields' => ['Descripcion'],
        'rules' => "'Descripcion' => 'required|max:255'"
    ],
    'Departamento' => [
        'fields' => ['nombre', 'IdPaisFK'],
        'rules' => "'nombre' => 'required|max:50',
                    'IdPaisFK' => 'required|integer'"
    ],
    'Empleado' => [
        'fields' => ['nombre', 'idCargoFK', 'fecha_ingreso', 'IdMunicipioFK'],
        'rules' => "'nombre' => 'required|max:50',
                    'idCargoFK' => 'required|integer',
                    'fecha_ingreso' => 'required|date',
                    'IdMunicipioFK' => 'required|integer'"
    ],
    'DetalleVenta' => [
        'fields' => ['IdVentaFk', 'IdInventarioFK', 'cantidad'],
        'rules' => "'IdVentaFk' => 'required|integer',
                    'IdInventarioFK' => 'required|integer',
                    'cantidad' => 'required|integer'"
    ],
    'DetalleOrden' => [
        'fields' => ['IdOrdenFk', 'IdPrendaFk', 'IdColorFK', 'IdTallaFK', 'PrendaId', 'cantidad_producir', 'cantidad_producida', 'IdEstadoFk'],
        'rules' => "'IdOrdenFk' => 'required|integer',
                    'IdPrendaFk' => 'required|integer',
                    'IdColorFK' => 'required|integer',
                    'IdTallaFK' => 'required|integer',
                    'PrendaId' => 'required|integer',
                    'cantidad_producir' => 'required|integer',
                    'cantidad_producida' => 'required|integer',
                    'IdEstadoFk' => 'required|integer'"
    ],
    'Genero' => [
        'fields' => ['descripcion'],
        'rules' => "'descripcion' => 'required|max:50'"
    ],
    'FormaPago' => [
        'fields' => ['Descripcion'],
        'rules' => "'Descripcion' => 'required|max:50'"
    ],
    'Estado' => [
        'fields' => ['Descripcion'],
        'rules' => "'Descripcion' => 'required|max:50'"
    ],
    'Empresa' => [
        'fields' => ['nit', 'razon_social', 'representante_legal', 'FechaCreacion', 'IdMunicipioFk'],
        'rules' => "'nit' => 'required|max:50',
                    'razon_social' => 'required',
                    'representante_legal' => 'required|max:50',
                    'FechaCreacion' => 'required|date',
                    'IdMunicipioFk' => 'required|integer'"
    ],
    'InsumoProveedor' => [
        'fields' => ['IdInsumoFK', 'IdProveedorFK'],
        'rules' => "'IdInsumoFK' => 'required|integer',
                    'IdProveedorFK' => 'required|integer'"
    ],
    'InsumoPrendas' => [
        'fields' => ['IdInsumoFk', 'IdPrendaFk', 'Cantidad'],
        'rules' => "'IdInsumoFk' => 'required|integer',
                    'IdPrendaFk' => 'required|integer',
                    'Cantidad' => 'required|integer'"
    ],
    'Insumo' => [
        'fields' => ['nombre', 'valor_unit', 'stock_min', 'stock_max'],
        'rules' => "'nombre' => 'required|max:50',
                    'valor_unit' => 'required|numeric',
                    'stock_min' => 'required|numeric',
                    'stock_max' => 'required|numeric'"
    ],
    'Orden' => [
        'fields' => ['fecha', 'IdEmpleadoFK', 'IdClienteFK', 'IdEstadoFK'],
        'rules' => "'fecha' => 'required|date',
                    'IdEmpleadoFK' => 'required|integer|exists:empleado,id',
                    'IdClienteFK' => 'required|integer|exists:cliente,id',
                    'IdEstadoFK' => 'required|integer|exists:estado,id'"
    ],
    'Municipio' => [
        'fields' => ['nombre', 'idDepartamentoFK'],
        'rules' => "'nombre' => 'required|string|max:50',
                    'idDepartamentoFK' => 'required|integer|exists:departamento,id'"
    ],
    'Inventario' => [
        'fields' => ['CodInv', 'IdPrendaFk', 'IdTallaFK', 'IdColorFK', 'Cantidad'],
        'rules' => "'CodInv' => 'required|string|max:255',
                    'IdPrendaFk' => 'required|integer|exists:prenda,id',
                    'IdTallaFK' => 'required|integer|exists:talla,id',
                    'IdColorFK' => 'required|integer|exists:color,id',
                    'Cantidad' => 'required|integer'"
    ],
    'Prenda' => [
        'fields' => ['Nombre', 'ValorUnitCop', 'ValorUnitUsd', 'IdEstadoFK', 'IdTipoProteccionFK', 'IdGeneroFK', 'Codigo'],
        'rules' => "'Nombre' => 'required|string|max:50',
                    'ValorUnitCop' => 'required|numeric',
                    'ValorUnitUsd' => 'required|numeric',
                    'IdEstadoFK' => 'required|integer|exists:estado,id',
                    'IdTipoProteccionFK' => 'required|integer|exists:tipo_proteccion,id',
                    'IdGeneroFK' => 'required|integer|exists:genero,id',
                    'Codigo' => 'required|string|max:50'"
    ],
    'Pais' => [
        'fields' => ['nombre'],
        'rules' => "'nombre' => 'required|string|max:50'"
    ],
    'Proveedor' => [
        'fields' => ['NitProovedor', 'Nombre', 'IdTipoPersonaFK'],
        'rules' => "'NitProovedor' => 'required|string|max:50',
                    'Nombre' => 'required|string|max:50',
                    'IdTipoPersonaFK' => 'required|integer|exists:tipo_persona,id'"
    ],
    'TipoProteccion' => [
        'fields' => ['Descripcion'],
        'rules' => "'Descripcion' => 'required|string|max:50'"
    ],
    'TipoPersona' => [
        'fields' => ['Descripcion'],
        'rules' => "'Descripcion' => 'required|string|max:50'"
    ],
    'Talla' => [
        'fields' => ['Descripcion'],
        'rules' => "'Descripcion' => 'required|string|max:50'"
    ],
    'Venta' => [
        'fields' => ['FechaVenta', 'IdClienteFK', 'IdFormaPagoFK'],
        'rules' => "'FechaVenta' => 'required|date',
                    'IdClienteFK' => 'required|integer|exists:cliente,id',
                    'IdFormaPagoFK' => 'required|integer|exists:forma_pago,id'"
    ],
];

foreach ($controllers as $name) {
    $fields = isset($validators[$name]['fields']) ? $validators[$name]['fields'] : [];
    $rules = isset($validators[$name]['rules']) ? $validators[$name]['rules'] : '';

    $fieldsString = "'" . implode("', '", $fields) . "'";
    $controllerContent = str_replace(
        ['{NAME}', '{name}', '{FIELDS}', '[VALIDATOR_RULES]'],
        [$name, lcfirst($name), $fieldsString, $rules],
        $controllerTemplate
    );

    $dir = __DIR__ . "/app/Http/Controllers/Api/v1/crud";
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    file_put_contents("$dir/{$name}Controller.php", $controllerContent);
    echo "{$name}Controller.php created successfully.\n";
}

