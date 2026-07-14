<?php

namespace App\Helpers;

use Sentry\SentrySdk;
use Sentry\State\Hub;
use Sentry\Transport\ResultStatus;

class SentryHelper
{
    public static function settings(): array
    {
        return [
            'enabled' => SettingsHelper::get('sentry_enabled', '0') === '1',
            'dsn'     => SettingsHelper::get('sentry_dsn', ''),
        ];
    }

    public static function isConfigured(): bool
    {
        $s = static::settings();
        return $s['enabled'] && filled($s['dsn']);
    }

    /** Inicializa el SDK de Sentry con el DSN guardado, si está activo. Se llama en cada boot de la app. */
    public static function applyToRuntimeConfig(): void
    {
        if (!static::isConfigured()) {
            return;
        }

        \Sentry\init([
            'dsn'                => static::settings()['dsn'],
            'environment'        => config('app.env'),
            'traces_sample_rate' => 0,
        ]);
    }

    /**
     * Manda un evento de prueba con un DSN dado (no necesariamente el guardado) y espera
     * la confirmación real de entrega antes de responder. Devuelve ['ok' => bool, 'message' => string].
     */
    public static function sendTestEvent(string $dsn): array
    {
        try {
            $options = new \Sentry\Options(['dsn' => $dsn]);
            $client  = (new \Sentry\ClientBuilder($options))->getClient();
            $hub     = new Hub($client);
            SentrySdk::setCurrentHub($hub);

            $eventId = \Sentry\captureMessage('Prueba de configuración de Sentry — Enrique Delgado');

            if ($eventId === null) {
                return ['ok' => false, 'message' => 'El DSN no es válido o el evento no se pudo generar.'];
            }

            $result = $hub->getClient()?->flush(5);

            if ($result && $result->getStatus() === ResultStatus::success()) {
                return ['ok' => true, 'message' => '✓ Se mandó un evento de prueba a Sentry. Revisá tu proyecto en sentry.io para confirmar que llegó.'];
            }

            $status = $result ? (string) $result->getStatus() : 'unknown';
            return ['ok' => false, 'message' => "No se pudo confirmar la entrega (estado: {$status}). Revisá que el DSN sea correcto."];
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}
