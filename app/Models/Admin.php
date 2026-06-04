<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Authenticatable
{
    protected $table = 'admin';

    protected $fillable = [
        'username',
        'email',
        'password',
        'organization_id',
        'role',
        'mobile_number',
        'rwa_election_copy',
        'social_registration_number',
        'is_id_verified',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_id_verified' => 'boolean',
    ];

    public function getRoleAttribute(): string
    {
        return $this->attributes['role'] ?? 'admin';
    }

    public function getAccountTypeAttribute(): string
    {
        return 'admin';
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
