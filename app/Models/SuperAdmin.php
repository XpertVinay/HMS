<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Maps to the 'super_admin' table.
 */
class SuperAdmin extends Authenticatable implements JWTSubject
{
    protected $table = 'super_admin';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    /**
     * Super admins are global — not scoped to any organization.
     */
    public function getAccountTypeAttribute(): string
    {
        return 'super_admin';
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
            'role' => 'super_admin'
        ];
    }
}
