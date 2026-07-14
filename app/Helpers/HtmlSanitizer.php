<?php

namespace App\Helpers;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlSanitizer
{
    /**
     * Limpia HTML guardado desde los editores de texto enriquecido (TinyMCE) del admin.
     * Whitelist ajustada a lo que los toolbars realmente ofrecen — nada de <script>,
     * event handlers (onclick, onload...), ni links "javascript:". Se aplica en el
     * momento de guardar, no solo al mostrar, para que lo que quede en la base ya
     * esté limpio (defensa en profundidad: si alguien compromete la cuenta admin y
     * manda HTML directo al backend sin pasar por el editor, igual queda filtrado).
     */
    public static function clean(?string $html): string
    {
        if (!$html) {
            return '';
        }

        static $purifier = null;

        if ($purifier === null) {
            $cachePath = storage_path('app/htmlpurifier-cache');
            if (!is_dir($cachePath)) {
                mkdir($cachePath, 0755, true);
            }

            $config = HTMLPurifier_Config::createDefault();
            $config->set('HTML.Allowed', 'p,br,strong,b,em,i,u,ul,ol,li,a[href],h1,h2,h3,h4,h5,h6');
            $config->set('HTML.TargetBlank', false);
            $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true]);
            $config->set('Cache.SerializerPath', $cachePath);
            $config->set('Attr.EnableID', false);

            $purifier = new HTMLPurifier($config);
        }

        return $purifier->purify($html);
    }
}
