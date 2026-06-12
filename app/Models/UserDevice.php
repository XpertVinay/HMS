<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    protected $table = 'user_devices';

    protected $fillable = [
        'user_type',
        'user_id',
        'organization_id',
        'device_uuid',
        'os_type',
        'device_model',
        'fcm_token',
        'status',
        'last_login_at',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithFcmToken($query)
    {
        return $query->whereNotNull('fcm_token')->where('fcm_token', '!=', '');
    }
}
