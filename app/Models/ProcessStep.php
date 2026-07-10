<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcessStep extends Model
{
    use SoftDeletes;

    protected $fillable = ['step_number', 'title', 'description', 'icon', 'is_active', 'order'];
    protected $casts    = ['is_active' => 'boolean'];

    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('order'); }
}
