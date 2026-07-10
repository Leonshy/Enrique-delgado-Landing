<?php

namespace App\Helpers;

class ThemeHelper
{
    /**
     * Roles de color editables desde el admin. Cada uno mapea a una
     * custom property CSS (--color-*) usada en toda la web pública y el panel.
     */
    public static function roles(): array
    {
        return [
            'color_primary' => [
                'var'         => '--color-primary',
                'label'       => 'Primario',
                'description' => 'Botones principales, links y elementos destacados.',
                'default'     => '#C86432',
            ],
            'color_primary_light' => [
                'var'         => '--color-primary-light',
                'label'       => 'Primario claro',
                'description' => 'Tonos secundarios, degradados y acentos suaves.',
                'default'     => '#D68B65',
            ],
            'color_primary_dark' => [
                'var'         => '--color-primary-dark',
                'label'       => 'Primario oscuro',
                'description' => 'Estados hover/activo de botones y links.',
                'default'     => '#A0563D',
            ],
            'color_accent' => [
                'var'         => '--color-accent',
                'label'       => 'Acento',
                'description' => 'Fondos de íconos, badges y detalles decorativos.',
                'default'     => '#F5DEB3',
            ],
            'color_brand_dark' => [
                'var'         => '--color-brand-dark',
                'label'       => 'Texto oscuro',
                'description' => 'Títulos, texto principal y fondos oscuros (footer, proceso).',
                'default'     => '#3A2115',
            ],
            'color_brand_light' => [
                'var'         => '--color-brand-light',
                'label'       => 'Fondo claro',
                'description' => 'Fondo general de la página y secciones claras.',
                'default'     => '#FDF8F2',
            ],
            'color_brand_muted' => [
                'var'         => '--color-brand-muted',
                'label'       => 'Fondo suave',
                'description' => 'Fondo alterno de secciones (wash suave entre bloques).',
                'default'     => '#FAEFDA',
            ],
        ];
    }

    /** Devuelve [--color-primary => '#C86432', ...] resolviendo overrides guardados o el default */
    public static function resolvedColors(): array
    {
        $resolved = [];
        foreach (static::roles() as $key => $role) {
            $resolved[$role['var']] = SettingsHelper::get($key, $role['default']);
        }
        return $resolved;
    }
}
