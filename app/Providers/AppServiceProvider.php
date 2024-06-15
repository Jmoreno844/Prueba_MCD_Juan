<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Array of controllers to bind
        $controllers = [
            "Cargo",
            'Cliente',
            'Color',
            'Departamento',
            'DetalleOrden',
            'DetalleVenta',
            'Empleado',
            'Empresa',
            'Estado',
            'FormaPago',
            'Genero',
            'Insumo',
            'InsumoPrendas',
            'InsumoProveedor',
            'Inventario',
            'Municipio',
            'Orden',
            'Pais',
            'Prenda',
            'Proveedor',
            'Talla',
            'TipoPersona',
            'TipoProteccion',
            'User',
            'Venta'
        ];

        // Loop through each controller and bind interfaces
        foreach ($controllers as $controller) {
            $serviceInterface = "App\Contracts\Services\\{$controller}ServiceInterface";
            $serviceClass = "App\Services\\{$controller}Service";
            $repositoryInterface = "App\Contracts\Repositories\\{$controller}RepositoryInterface";
            $repositoryClass = "App\Repositories\\{$controller}Repository";

            $this->app->bind($serviceInterface, $serviceClass);
            $this->app->bind($repositoryInterface, $repositoryClass);
        }
    }
}
