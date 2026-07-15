<?php

namespace App\Helpers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class SettingsHelper
{
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("setting_{$key}", 3600, fn () => SiteSetting::get($key, $default));
    }

    public static function set(string $key, mixed $value, ?string $group = null): void
    {
        SiteSetting::set($key, $value, $group);
        Cache::forget("setting_{$key}");
    }

    public static function whatsappUrl(?string $message = null): string
    {
        $number  = preg_replace('/[^0-9]/', '', static::get('whatsapp', '595981000000'));
        $message = urlencode($message ?: static::get('whatsapp_msg', 'Hola, me interesa una consulta.'));
        return "https://wa.me/{$number}?text={$message}";
    }
}
