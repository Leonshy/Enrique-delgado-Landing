<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionPlan extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'subtitle', 'description', 'is_featured', 'is_active', 'order'];
    protected $casts    = ['is_active' => 'boolean', 'is_featured' => 'boolean'];

    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('order'); }
}
