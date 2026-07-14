<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class HcaptchaHelper
{
    /** Formularios donde se puede activar hCaptcha. Clave => etiqueta visible en el admin. */
    public static function availableForms(): array
    {
        return [
            'contacto' => 'Formulario de contacto (página principal)',
            'login'    => 'Inicio de sesión del panel admin',
        ];
    }

    /** Formularios activados por defecto la primera vez (antes de guardar nada desde el admin). */
    public static function defaultEnabledForms(): array
    {
        return ['contacto'];
    }

    /** Claves de formularios actualmente activados. */
    public static function enabledForms(): array
    {
        $raw = SettingsHelper::get('hcaptcha_forms', '');

        if ($raw === '') {
            return static::defaultEnabledForms();
        }

        $forms = json_decode($raw, true);

        return is_array($forms) ? $forms : [];
    }

    /** ¿hCaptcha está activo globalmente y para este formulario en particular? */
    public static function isEnabledFor(string $form): bool
    {
        $globallyEnabled = SettingsHelper::get('hcaptcha_enabled', '0') === '1';

        return $globallyEnabled && in_array($form, static::enabledForms(), true);
    }

    /**
     * Verifica un token de hCaptcha resuelto contra la Secret Key.
     * Compartido entre el formulario de contacto, el login, y el test de conexión del admin.
     */
    public static function verify(string $secretKey, string $token, ?string $ip = null): array
    {
        if (!$secretKey || !$token) {
            return ['ok' => false, 'errors' => ['missing-input']];
        }

        try {
            $response = Http::timeout(8)->asForm()->post('https://hcaptcha.com/siteverify', array_filter([
                'secret'   => $secretKey,
                'response' => $token,
                'remoteip' => $ip,
            ]));
        } catch (\Exception) {
            return ['ok' => false, 'errors' => ['connection-failed']];
        }

        if ($response->json('success') === true) {
            return ['ok' => true, 'errors' => []];
        }

        return ['ok' => false, 'errors' => $response->json('error-codes', [])];
    }

    /** Traduce los códigos de error de hCaptcha a mensajes legibles en español. */
    public static function errorMessages(array $errorCodes): string
    {
        $map = [
            'missing-input'           => 'Por favor completá el captcha.',
            'connection-failed'       => 'No se pudo conectar con hCaptcha. Revisá la conexión saliente del servidor.',
            'invalid-input-secret'    => 'La Secret Key no es válida.',
            'sitekey-secret-mismatch' => 'La Site Key y la Secret Key no pertenecen al mismo sitio en hCaptcha.',
            'invalid-input-response'  => 'El desafío no se pudo verificar (puede haber expirado). Volvé a resolverlo y probá de nuevo.',
            'timeout-or-duplicate'    => 'El desafío ya expiró o se usó antes. Volvé a resolverlo y probá de nuevo.',
        ];

        $message = collect($errorCodes)->map(fn ($e) => $map[$e] ?? $e)->implode(' ');

        return $message ?: 'No se pudo verificar el captcha.';
    }
}
