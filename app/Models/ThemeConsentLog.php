<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeConsentLog extends Model
{
    protected $fillable = [
        'organization_id',
        'admin_id',
        'action',
        'ip_address',
        'user_agent',
        'theme_data',
    ];

    protected $casts = [
        'theme_data' => 'array',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'admin_id');
    }
}
