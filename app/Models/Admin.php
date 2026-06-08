<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasPersonName;
use App\Traits\TenantScoped;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Maps to the 'admin' table.
 */
class Admin extends Authenticatable implements JWTSubject
{
    use HasPersonName, TenantScoped, Notifiable;

    protected $table = 'admin';

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
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
            'role' => 'admin',
            'organization_id' => $this->organization_id
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
