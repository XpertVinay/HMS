<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resident extends Authenticatable
{
    protected $table = 'resident';

    protected $fillable = [
        'username',
        'email',
        'password',
        'address',
        'mobile_number',
        'organization_id',
        'owner_noc',
        'is_rent_agreement_verified_staff',
        'is_rent_agreement_verified_admin',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_rent_agreement_verified_staff' => 'boolean',
        'is_rent_agreement_verified_admin' => 'boolean',
    ];

    public function getAccountTypeAttribute(): string
    {
        return 'resident';
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'resident_id');
    }
}
