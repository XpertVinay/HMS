<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\TenantScoped;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use TenantScoped;

    protected $table = 'member';

    protected $fillable = [
        'username',
        'email',
        'password',
        'address',
        'phone',
        'organization_id',
        'share_certificate',
        'is_deed_verified_staff',
        'is_deed_verified_admin',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_deed_verified_staff' => 'boolean',
        'is_deed_verified_admin' => 'boolean',
    ];

    public function getAccountTypeAttribute(): string
    {
        return 'member';
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
            'role' => 'member',
            'organization_id' => $this->organization_id
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class, 'member_id');
    }

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'member_id');
    }

    public function communityPosts(): HasMany
    {
        return $this->hasMany(CommunityPost::class, 'member_id');
    }

    public function solidApprovals(): HasMany
    {
        return $this->hasMany(SolidApproval::class, 'member_id');
    }
}
