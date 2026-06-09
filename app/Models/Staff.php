<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasPersonName;
use App\Traits\HasPushNotifications;
use App\Traits\TenantScoped;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Maps to the 'staff' table.
 */
class Staff extends Authenticatable implements JWTSubject
{
    use HasPersonName, HasPushNotifications, TenantScoped;

    protected $table = 'staff';

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
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
            'role' => 'staff',
            'organization_id' => $this->organization_id
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
