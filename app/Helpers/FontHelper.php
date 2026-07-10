<?php

namespace App\Helpers;

class FontHelper
{
    public const CUSTOM_HEADING_KEY = 'custom_heading';
    public const CUSTOM_BODY_KEY    = 'custom_body';

    /** Fuentes de Google Fonts disponibles para títulos (H1-H4, textos destacados). */
    public static function headingFonts(): array
    {
        return [
            'playfair'          => ['label' => 'Playfair Display',   'category' => 'serif', 'query' => 'Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600'],
            'merriweather'      => ['label' => 'Merriweather',       'category' => 'serif', 'query' => 'Merriweather:ital,wght@0,400;0,700;1,400'],
            'lora'              => ['label' => 'Lora',               'category' => 'serif', 'query' => 'Lora:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'cormorant'         => ['label' => 'Cormorant Garamond', 'category' => 'serif', 'query' => 'Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'libre_baskerville' => ['label' => 'Libre Baskerville',  'category' => 'serif', 'query' => 'Libre+Baskerville:ital,wght@0,400;0,700;1,400'],
            'dm_serif'          => ['label' => 'DM Serif Display',   'category' => 'serif', 'query' => 'DM+Serif+Display:ital,wght@0,400;1,400'],
            'fraunces'          => ['label' => 'Fraunces',           'category' => 'serif', 'query' => 'Fraunces:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'prata'             => ['label' => 'Prata',              'category' => 'serif', 'query' => 'Prata:wght@400'],
            'crimson_text'      => ['label' => 'Crimson Text',       'category' => 'serif', 'query' => 'Crimson+Text:ital,wght@0,400;0,600;0,700;1,400'],
            'eb_garamond'       => ['label' => 'EB Garamond',        'category' => 'serif', 'query' => 'EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'cardo'             => ['label' => 'Cardo',              'category' => 'serif', 'query' => 'Cardo:ital,wght@0,400;0,700;1,400'],
            'bitter'            => ['label' => 'Bitter',             'category' => 'serif', 'query' => 'Bitter:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'pt_serif'          => ['label' => 'PT Serif',           'category' => 'serif', 'query' => 'PT+Serif:ital,wght@0,400;0,700;1,400'],
            'spectral'          => ['label' => 'Spectral',           'category' => 'serif', 'query' => 'Spectral:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'abril_fatface'     => ['label' => 'Abril Fatface',      'category' => 'serif', 'query' => 'Abril+Fatface'],
            'cinzel'            => ['label' => 'Cinzel',             'category' => 'serif', 'query' => 'Cinzel:wght@400;500;600;700'],
            'marcellus'         => ['label' => 'Marcellus',          'category' => 'serif', 'query' => 'Marcellus'],
            'domine'            => ['label' => 'Domine',             'category' => 'serif', 'query' => 'Domine:wght@400;500;600;700'],
            'vollkorn'          => ['label' => 'Vollkorn',           'category' => 'serif', 'query' => 'Vollkorn:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'italiana'          => ['label' => 'Italiana',           'category' => 'serif', 'query' => 'Italiana'],
            'montserrat'        => ['label' => 'Montserrat',         'category' => 'sans',  'query' => 'Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'poppins'           => ['label' => 'Poppins',            'category' => 'sans',  'query' => 'Poppins:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'josefin_sans'      => ['label' => 'Josefin Sans',       'category' => 'sans',  'query' => 'Josefin+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'raleway'           => ['label' => 'Raleway',            'category' => 'sans',  'query' => 'Raleway:ital,wght@0,400;0,500;0,600;0,700;1,400'],
            'oswald'            => ['label' => 'Oswald',             'category' => 'sans',  'query' => 'Oswald:wght@400;500;600;700'],
            'bebas_neue'        => ['label' => 'Bebas Neue',         'category' => 'sans',  'query' => 'Bebas+Neue'],
            'quicksand'         => ['label' => 'Quicksand',          'category' => 'sans',  'query' => 'Quicksand:wght@400;500;600;700'],
        ];
    }

    /** Fuentes de Google Fonts disponibles para texto general (párrafos, menú, botones). */
    public static function bodyFonts(): array
    {
        return [
            'inter'         => ['label' => 'Inter',             'category' => 'sans', 'query' => 'Inter:wght@300;400;500;600;700'],
            'roboto'        => ['label' => 'Roboto',            'category' => 'sans', 'query' => 'Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400'],
            'open_sans'     => ['label' => 'Open Sans',         'category' => 'sans', 'query' => 'Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'lato'          => ['label' => 'Lato',              'category' => 'sans', 'query' => 'Lato:ital,wght@0,300;0,400;0,700;1,400'],
            'nunito_sans'   => ['label' => 'Nunito Sans',       'category' => 'sans', 'query' => 'Nunito+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'nunito'        => ['label' => 'Nunito',            'category' => 'sans', 'query' => 'Nunito:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'source_sans'   => ['label' => 'Source Sans 3',     'category' => 'sans', 'query' => 'Source+Sans+3:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'work_sans'     => ['label' => 'Work Sans',         'category' => 'sans', 'query' => 'Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'mulish'        => ['label' => 'Mulish',            'category' => 'sans', 'query' => 'Mulish:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'dm_sans'       => ['label' => 'DM Sans',           'category' => 'sans', 'query' => 'DM+Sans:ital,wght@0,400;0,500;0,700;1,400'],
            'karla'         => ['label' => 'Karla',             'category' => 'sans', 'query' => 'Karla:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'rubik'         => ['label' => 'Rubik',             'category' => 'sans', 'query' => 'Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'manrope'       => ['label' => 'Manrope',           'category' => 'sans', 'query' => 'Manrope:wght@300;400;500;600;700'],
            'figtree'       => ['label' => 'Figtree',           'category' => 'sans', 'query' => 'Figtree:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'plus_jakarta'  => ['label' => 'Plus Jakarta Sans', 'category' => 'sans', 'query' => 'Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'urbanist'      => ['label' => 'Urbanist',          'category' => 'sans', 'query' => 'Urbanist:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'outfit'        => ['label' => 'Outfit',            'category' => 'sans', 'query' => 'Outfit:wght@300;400;500;600;700'],
            'sora'          => ['label' => 'Sora',              'category' => 'sans', 'query' => 'Sora:wght@300;400;500;600;700'],
            'hanken_grotesk'=> ['label' => 'Hanken Grotesk',    'category' => 'sans', 'query' => 'Hanken+Grotesk:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'jost'          => ['label' => 'Jost',              'category' => 'sans', 'query' => 'Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'albert_sans'   => ['label' => 'Albert Sans',       'category' => 'sans', 'query' => 'Albert+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'archivo'       => ['label' => 'Archivo',           'category' => 'sans', 'query' => 'Archivo:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'ibm_plex_sans' => ['label' => 'IBM Plex Sans',     'category' => 'sans', 'query' => 'IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'mukta'         => ['label' => 'Mukta',             'category' => 'sans', 'query' => 'Mukta:wght@300;400;500;600;700'],
            'barlow'        => ['label' => 'Barlow',            'category' => 'sans', 'query' => 'Barlow:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'asap'          => ['label' => 'Asap',              'category' => 'sans', 'query' => 'Asap:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400'],
            'cabin'         => ['label' => 'Cabin',             'category' => 'sans', 'query' => 'Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400'],
        ];
    }

    /** Escalas de tamaño general del texto (porcentaje aplicado al font-size raíz). */
    public static function sizeScales(): array
    {
        return [
            '93.75'  => 'Compacto',
            '100'    => 'Normal',
            '106.25' => 'Grande',
            '112.5'  => 'Extra grande',
        ];
    }

    /** Tipografía propia subida para un slot ('heading' o 'body'), o null si no hay ninguna. */
    public static function customFont(string $slot): ?array
    {
        $path  = SettingsHelper::get("font_{$slot}_custom_path");
        $label = SettingsHelper::get("font_{$slot}_custom_label");

        if (!$path) {
            return null;
        }

        return [
            'path'   => $path,
            'label'  => $label ?: 'Fuente personalizada',
            'family' => $slot === 'heading' ? 'CustomHeadingFont' : 'CustomBodyFont',
            'format' => static::fontFormat($path),
        ];
    }

    /** Claves actualmente guardadas (o los valores por defecto). */
    public static function selected(): array
    {
        $headingKey = SettingsHelper::get('font_heading', 'playfair');
        $bodyKey    = SettingsHelper::get('font_body', 'inter');
        $scale      = SettingsHelper::get('font_scale', '100');

        $headings = static::headingFonts();
        $bodies   = static::bodyFonts();
        $scales   = static::sizeScales();

        $headingIsCustom = $headingKey === static::CUSTOM_HEADING_KEY && static::customFont('heading');
        $bodyIsCustom    = $bodyKey === static::CUSTOM_BODY_KEY && static::customFont('body');

        if (!$headingIsCustom && !isset($headings[$headingKey])) {
            $headingKey = 'playfair';
        }
        if (!$bodyIsCustom && !isset($bodies[$bodyKey])) {
            $bodyKey = 'inter';
        }
        if (!isset($scales[$scale])) {
            $scale = '100';
        }

        return compact('headingKey', 'bodyKey', 'scale');
    }

    /** [--font-serif => "'X', ui-serif...", --font-sans => "'Y', ui-sans-serif..."] para inyectar en :root */
    public static function cssVars(): array
    {
        $s        = static::selected();
        $headings = static::headingFonts();
        $bodies   = static::bodyFonts();

        $serif = $s['headingKey'] === static::CUSTOM_HEADING_KEY
            ? "'CustomHeadingFont', ui-serif, Georgia, serif"
            : static::cssFamily($headings[$s['headingKey']]);

        $sans = $s['bodyKey'] === static::CUSTOM_BODY_KEY
            ? "'CustomBodyFont', ui-sans-serif, system-ui, sans-serif"
            : static::cssFamily($bodies[$s['bodyKey']]);

        return [
            '--font-serif' => $serif,
            '--font-sans'  => $sans,
        ];
    }

    /** Porcentaje a aplicar como font-size del elemento raíz (html). */
    public static function rootFontSize(): string
    {
        return static::selected()['scale'] . '%';
    }

    /** URL del <link> combinado de Google Fonts para las fuentes de catálogo seleccionadas (null si ambas son personalizadas). */
    public static function googleFontsHref(): ?string
    {
        $s        = static::selected();
        $headings = static::headingFonts();
        $bodies   = static::bodyFonts();

        $queries = [];
        if ($s['headingKey'] !== static::CUSTOM_HEADING_KEY) {
            $queries[] = $headings[$s['headingKey']]['query'];
        }
        if ($s['bodyKey'] !== static::CUSTOM_BODY_KEY) {
            $queries[] = $bodies[$s['bodyKey']]['query'];
        }
        $queries = array_unique($queries);

        if (!$queries) {
            return null;
        }

        $families = implode('&', array_map(fn ($q) => 'family=' . $q, $queries));

        return "https://fonts.googleapis.com/css2?{$families}&display=swap";
    }

    private static function cssFamily(array $font): string
    {
        $fallback = $font['category'] === 'serif'
            ? 'ui-serif, Georgia, serif'
            : 'ui-sans-serif, system-ui, sans-serif';

        return "'{$font['label']}', {$fallback}";
    }

    private static function fontFormat(string $path): string
    {
        return match (strtolower(pathinfo($path, PATHINFO_EXTENSION))) {
            'woff2' => 'woff2',
            'woff'  => 'woff',
            'otf'   => 'opentype',
            default => 'truetype',
        };
    }
}
