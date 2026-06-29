<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingSection extends Model
{
    protected $fillable = [
        'slug', 'title', 'subtitle', 'body', 'extra',
        'cta_text', 'cta_url', 'image_path', 'image_alt', 'is_active', 'order',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public static function bySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }
}
