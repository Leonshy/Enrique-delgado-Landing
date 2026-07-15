<?php

namespace App\Helpers;

class ButtonHelper
{
    /** Botones globales (no atados a ninguna sección) configurables en /admin/settings/botones. */
    public static function globalDefaults(): array
    {
        return [
            'navbar_cta'     => ['label' => 'Agendar sesión',     'icon' => 'none',     'action_type' => 'url',      'url' => '#contacto', 'url_target' => '_self'],
            'footer_cta'     => ['label' => 'Solicitar consulta', 'icon' => 'none',     'action_type' => 'url',      'url' => '#contacto', 'url_target' => '_self'],
            'whatsapp_float' => ['label' => '',                   'icon' => 'whatsapp', 'action_type' => 'whatsapp'],
        ];
    }

    /** Config guardada (o default) de un botón global por su key. */
    public static function get(string $key): array
    {
        $defaults = static::globalDefaults()[$key] ?? [];
        $stored   = json_decode(SettingsHelper::get("button_{$key}", '') ?: '{}', true) ?: [];
        return array_merge($defaults, $stored);
    }

    public static function set(string $key, array $data): void
    {
        SettingsHelper::set("button_{$key}", json_encode($data));
    }

    public static function resolveKey(string $key, int $iconSize = 17): array
    {
        return static::resolve(static::get($key), $iconSize);
    }

    /**
     * Resuelve una configuración plana de botón a lo que la vista necesita.
     * $cfg: ['label','icon','action_type','url','url_target','email_to','email_subject','email_body','whatsapp_message']
     * $enforceWhatsappStyle: si es false, el botón de WhatsApp no fuerza su ícono/color propio
     * (usado por los botones de Planes, que son la excepción a esa regla).
     */
    public static function resolve(array $cfg, int $iconSize = 17, bool $enforceWhatsappStyle = true): array
    {
        $actionType = $cfg['action_type'] ?? 'url';

        $href = match ($actionType) {
            'email'    => static::mailto($cfg),
            'whatsapp' => SettingsHelper::whatsappUrl($cfg['whatsapp_message'] ?? null),
            default    => $cfg['url'] ?? '#',
        };

        $target = match ($actionType) {
            'whatsapp' => '_blank',
            'email'    => '_self',
            default    => ($cfg['url_target'] ?? '_self') === '_blank' ? '_blank' : '_self',
        };

        // El botón de WhatsApp siempre usa su propio ícono y color — salvo excepción explícita.
        $whatsappStyle = $actionType === 'whatsapp' && $enforceWhatsappStyle;
        $icon = $whatsappStyle ? 'whatsapp' : ($cfg['icon'] ?? null);

        return [
            'label'          => $cfg['label'] ?? '',
            'icon_svg'       => IconHelper::render($icon, $iconSize),
            'href'           => $href,
            'target'         => $target,
            'action_type'    => $actionType,
            'whatsapp_style' => $whatsappStyle,
        ];
    }

    private static function mailto(array $cfg): string
    {
        $to     = $cfg['email_to'] ?? '';
        $params = array_filter([
            'subject' => $cfg['email_subject'] ?? '',
            'body'    => $cfg['email_body'] ?? '',
        ]);

        if (!$params) {
            return "mailto:{$to}";
        }

        $query = implode('&', array_map(
            fn ($key, $value) => $key . '=' . rawurlencode($value),
            array_keys($params),
            array_values($params)
        ));

        return "mailto:{$to}?{$query}";
    }
}
