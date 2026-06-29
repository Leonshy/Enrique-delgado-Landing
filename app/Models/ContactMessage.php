<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'phone', 'email', 'message', 'privacy_accepted',
        'ip_address', 'user_agent', 'is_read', 'responded_at',
    ];

    protected $casts = [
        'is_read'          => 'boolean',
        'privacy_accepted' => 'boolean',
        'responded_at'     => 'datetime',
    ];

    public function scopeUnread($query) { return $query->where('is_read', false); }
    public function scopeRecent($query) { return $query->orderByDesc('created_at'); }
}
