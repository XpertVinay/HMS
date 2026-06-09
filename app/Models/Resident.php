<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\HasPersonName;
use App\Traits\HasPushNotifications;
use App\Traits\TenantScoped;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Resident extends Authenticatable implements JWTSubject
{
    use HasPersonName, HasPushNotifications, TenantScoped;

    protected $table = 'resident';

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
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

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'role' => 'resident',
            'organization_id' => $this->organization_id
        ];
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
