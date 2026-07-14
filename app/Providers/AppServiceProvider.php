<?php

namespace App\Providers;

use App\Helpers\MailSettingsHelper;
use App\Helpers\SentryHelper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Si hay SMTP cargado desde Admin > Configuración > Email, pisa lo que venga del .env.
        // Si no, sigue funcionando con MAIL_* del .env como siempre.
        // Se aplica también en consola (necesario para que el queue worker mande los emails
        // encolados con esta config), pero se ignora cualquier error de BD — por ejemplo,
        // la primera vez que se corre "php artisan migrate" la tabla site_settings todavía
        // no existe, y no tiene que romper el comando.
        try {
            MailSettingsHelper::applyToRuntimeConfig();
        } catch (\Throwable) {
            //
        }

        // Igual que con el mail: si hay un DSN de Sentry cargado en Admin > Integraciones,
        // se inicializa el SDK. Si no, no pasa nada (el sitio sigue sin monitoreo de errores).
        try {
            SentryHelper::applyToRuntimeConfig();
        } catch (\Throwable) {
            //
        }
    }
}
