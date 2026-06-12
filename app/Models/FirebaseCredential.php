<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirebaseCredential extends Model
{
    protected $fillable = [
        'project_key',
        'credentials',
        'is_active',
    ];

    protected $casts = [
        'credentials' => 'array',
        'is_active' => 'boolean',
    ];
}
