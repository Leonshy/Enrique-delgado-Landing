<?php

namespace App\Helpers;

class MailSettingsHelper
{
    /** Opciones de seguridad disponibles para el SMTP. Clave => [etiqueta, puerto sugerido, scheme de Symfony Mailer]. */
    public static function encryptionOptions(): array
    {
        return [
            'ssl_tls'  => ['label' => 'SSL/TLS (implícito)', 'default_port' => 465, 'scheme' => 'smtps'],
            'starttls' => ['label' => 'STARTTLS (explícito)', 'default_port' => 587, 'scheme' => 'smtp'],
            'none'     => ['label' => 'Sin cifrado',          'default_port' => 25,  'scheme' => 'smtp'],
        ];
    }

    /** Valores actualmente guardados (o los defaults pedidos: puerto 465, SSL/TLS). */
    public static function settings(): array
    {
        return [
            'host'           => SettingsHelper::get('mail_host', ''),
            'port'           => SettingsHelper::get('mail_port', '465'),
            'encryption'     => SettingsHelper::get('mail_encryption', 'ssl_tls'),
            'username'       => SettingsHelper::get('mail_username', ''),
            'password'       => SettingsHelper::get('mail_password', ''),
            'from_address'   => SettingsHelper::get('mail_from_address', ''),
            'from_name'      => SettingsHelper::get('mail_from_name', ''),
        ];
    }

    /** ¿Hay una configuración de SMTP cargada desde el admin? Si no, se usa la del .env como hasta ahora. */
    public static function isConfigured(): bool
    {
        $s = static::settings();
        return filled($s['host']) && filled($s['username']);
    }

    /** Aplica la configuración del admin sobre config('mail.*') en tiempo de ejecución, si está cargada. */
    public static function applyToRuntimeConfig(): void
    {
        if (!static::isConfigured()) {
            return;
        }

        $s        = static::settings();
        $scheme   = static::encryptionOptions()[$s['encryption']]['scheme'] ?? 'smtp';

        config([
            'mail.default'              => 'smtp',
            'mail.mailers.smtp.transport' => 'smtp',
            'mail.mailers.smtp.scheme'    => $scheme,
            'mail.mailers.smtp.host'      => $s['host'],
            'mail.mailers.smtp.port'      => (int) $s['port'],
            'mail.mailers.smtp.username'  => $s['username'],
            'mail.mailers.smtp.password'  => $s['password'],
        ]);

        if (filled($s['from_address'])) {
            config(['mail.from.address' => $s['from_address']]);
        }
        if (filled($s['from_name'])) {
            config(['mail.from.name' => $s['from_name']]);
        }
    }

    /**
     * Manda un email de prueba con credenciales dadas (no necesariamente las guardadas),
     * para poder probar antes de guardar. Devuelve ['ok' => bool, 'message' => string].
     */
    public static function sendTestEmail(array $settings, string $to): array
    {
        $scheme = static::encryptionOptions()[$settings['encryption']]['scheme'] ?? 'smtp';

        $dsn = sprintf(
            '%s://%s:%s@%s:%s',
            $scheme,
            rawurlencode($settings['username']),
            rawurlencode($settings['password']),
            $settings['host'],
            $settings['port']
        );

        try {
            $transport = \Symfony\Component\Mailer\Transport::fromDsn($dsn);
            $mailer    = new \Symfony\Component\Mailer\Mailer($transport);

            $email = (new \Symfony\Component\Mime\Email())
                ->from($settings['from_address'] ?: $settings['username'])
                ->to($to)
                ->subject('Prueba de configuración SMTP — Enrique Delgado')
                ->text('Si recibiste este correo, la configuración de SMTP del panel admin funciona correctamente.');

            $mailer->send($email);

            return ['ok' => true, 'message' => "✓ Conexión correcta. Se mandó un email de prueba a {$to}."];
        } catch (\Throwable $e) {
            return ['ok' => false, 'message' => 'No se pudo enviar: ' . $e->getMessage()];
        }
    }
}
