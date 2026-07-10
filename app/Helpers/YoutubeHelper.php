<?php

namespace App\Helpers;

class YoutubeHelper
{
    /** Extrae el ID de video de una URL de YouTube (watch, youtu.be, embed, shorts). Null si no es válida. */
    public static function extractId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([A-Za-z0-9_-]{11})/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
