<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class Staff extends Authenticatable
{
    use TenantScoped;

    protected $table = 'staff';

    protected $fillable = [
        'username',
        'email',
        'password',
        'organization_id',
        'mobile_number',
        'employment_contract',
        'is_id_verified',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_id_verified' => 'boolean',
    ];

    public function getAccountTypeAttribute(): string
    {
        return 'staff';
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
