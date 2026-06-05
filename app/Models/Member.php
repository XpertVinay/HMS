<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\TenantScoped;

class Member extends Authenticatable
{
    use TenantScoped;

    protected $table = 'member';

    const UPDATED_AT = null;

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
