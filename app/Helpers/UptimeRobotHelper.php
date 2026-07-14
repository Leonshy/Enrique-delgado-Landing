<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class UptimeRobotHelper
{
    private const API_BASE = 'https://api.uptimerobot.com/v2/';

    public static function settings(): array
    {
        return [
            'enabled'    => SettingsHelper::get('uptimerobot_enabled', '0') === '1',
            'api_key'    => SettingsHelper::get('uptimerobot_api_key', ''),
            'monitor_id' => SettingsHelper::get('uptimerobot_monitor_id', ''),
        ];
    }

    public static function isConfigured(): bool
    {
        $s = static::settings();
        return $s['enabled'] && filled($s['api_key']);
    }

    /** Valida que la API key funcione, pegándole de verdad a la API de UptimeRobot. */
    public static function verifyApiKey(string $apiKey): array
    {
        try {
            $response = Http::asForm()->post(self::API_BASE . 'getAccountDetails', [
                'api_key' => $apiKey,
                'format'  => 'json',
            ]);
        } catch (\Throwable) {
            return ['ok' => false, 'message' => 'No se pudo conectar con la API de UptimeRobot.'];
        }

        $data = $response->json();

        if (($data['stat'] ?? null) === 'ok') {
            $limit = $data['account']['monitor_limit'] ?? '?';
            $used  = $data['account']['up_monitors'] ?? 0 + ($data['account']['down_monitors'] ?? 0);
            return ['ok' => true, 'message' => "✓ API key válida. Tu cuenta permite hasta {$limit} monitores.", 'data' => $data];
        }

        return ['ok' => false, 'message' => 'API key inválida: ' . ($data['error']['message'] ?? 'motivo desconocido')];
    }

    /** Crea un monitor HTTP(s) apuntando a la URL del sitio. Devuelve el monitor_id si funciona. */
    public static function createMonitor(string $apiKey, string $url, string $friendlyName): array
    {
        try {
            $response = Http::asForm()->post(self::API_BASE . 'newMonitor', [
                'api_key'      => $apiKey,
                'format'       => 'json',
                'type'         => 1, // HTTP(s)
                'url'          => $url,
                'friendly_name' => $friendlyName,
                'interval'     => 300, // cada 5 minutos
            ]);
        } catch (\Throwable) {
            return ['ok' => false, 'message' => 'No se pudo conectar con la API de UptimeRobot.'];
        }

        $data = $response->json();

        if (($data['stat'] ?? null) === 'ok') {
            return ['ok' => true, 'message' => '✓ Monitor creado correctamente.', 'monitor_id' => (string) $data['monitor']['id']];
        }

        return ['ok' => false, 'message' => 'No se pudo crear el monitor: ' . ($data['error']['message'] ?? 'motivo desconocido')];
    }

    /** Consulta el estado actual (real, en vivo) de un monitor ya creado. */
    public static function getMonitorStatus(string $apiKey, string $monitorId): array
    {
        try {
            $response = Http::asForm()->post(self::API_BASE . 'getMonitors', [
                'api_key'    => $apiKey,
                'format'     => 'json',
                'monitors'   => $monitorId,
            ]);
        } catch (\Throwable) {
            return ['ok' => false, 'message' => 'No se pudo conectar con la API de UptimeRobot.'];
        }

        $data = $response->json();

        if (($data['stat'] ?? null) !== 'ok' || empty($data['monitors'])) {
            return ['ok' => false, 'message' => 'No se pudo obtener el estado: ' . ($data['error']['message'] ?? 'monitor no encontrado')];
        }

        $monitor = $data['monitors'][0];
        $statusMap = [
            0 => 'Pausado',
            1 => 'Todavía sin datos',
            2 => 'Activo (up)',
            8 => 'Posible caída',
            9 => 'Caído (down)',
        ];
        $statusLabel = $statusMap[$monitor['status']] ?? 'Desconocido';

        return [
            'ok'      => true,
            'message' => "Estado actual: {$statusLabel}",
            'status'  => $monitor['status'],
        ];
    }
}
