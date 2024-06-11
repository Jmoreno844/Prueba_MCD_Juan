<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiVersion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Obtener la versión de la API desde la cadena de consulta
        $version = $request->query('version', 'v1');

        // Establecer el espacio de nombres del controlador basado en la versión
        $namespace = 'App\Http\Controllers\Api\\' . strtoupper($version);

        // Aplicar el namespace a las rutas del grupo
        Route::group(['namespace' => $namespace], function () use ($request, $next) {
            return $next($request);
        });

        return $next($request);
    }
}
