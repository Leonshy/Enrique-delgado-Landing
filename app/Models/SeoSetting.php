<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoSetting extends Model
{
    protected $fillable = [
        'page', 'meta_title', 'meta_description', 'slug', 'canonical_url',
        'og_image', 'og_title', 'og_description', 'noindex', 'nofollow',
    ];

    protected $casts = ['noindex' => 'boolean', 'nofollow' => 'boolean'];

    public static function forPage(string $page): ?self
    {
        return static::where('page', $page)->first();
    }
}
