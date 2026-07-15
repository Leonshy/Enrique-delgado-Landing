<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SessionPlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'subtitle', 'description', 'price', 'period', 'cta_label', 'whatsapp_text', 'is_featured', 'is_active', 'order',
        'icon', 'action_type', 'action_url', 'action_url_target', 'action_email_to', 'action_email_subject', 'action_email_body',
    ];
    protected $casts    = ['is_active' => 'boolean', 'is_featured' => 'boolean'];

    public function scopeActive($query) { return $query->where('is_active', true)->orderBy('order'); }
}
