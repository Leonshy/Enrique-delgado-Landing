<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin'            => \App\Http\Middleware\AdminMiddleware::class,
            'maintenance.mode' => \App\Http\Middleware\MaintenanceModeMiddleware::class,
        ]);

        // Plesk suele poner nginx delante de Apache/PHP en la misma máquina (maneja el
        // HTTPS y le pasa la petición por dentro). Sin esto, $request->ip() devuelve la
        // IP del proxy interno en vez de la del visitante real, lo que rompería el rate
        // limiting por IP del login y del formulario de contacto (todos compartirían el
        // mismo contador). Se confía solo en IPs privadas/locales, no en cualquiera.
        $middleware->trustProxies(at: [
            '127.0.0.1',
            '::1',
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // No hace nada si Sentry nunca se inicializó (sitio sin configurar en
        // Admin > Integraciones) — es seguro dejarlo siempre registrado.
        Integration::handles($exceptions);
    })->create();
