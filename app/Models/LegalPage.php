<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalPage extends Model
{
    protected $fillable = ['slug', 'title', 'content', 'show_in_footer', 'is_active'];
    protected $casts    = ['show_in_footer' => 'boolean', 'is_active' => 'boolean'];

    public static function bySlug(string $slug): ?self
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }
}
