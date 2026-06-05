<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $table = 'organizations';

    protected $fillable = [
        'name',
        'address',
        'registration_code',
        'subdomain',
        'status',
        'logo_url',
        'primary_color',
        'secondary_color',
        'solid_sale_charge',
        'solid_occupancy_charge',
        'solid_lease_charge',
        'solid_interior_charge',
        'solid_decoration_charge',
    ];

    /**
     * Default brand values used when org has no custom branding.
     */
    const DEFAULT_LOGO = '/assets/images/businzo_logo.png';
    const DEFAULT_PRIMARY_COLOR = '#4f46e5';
    const DEFAULT_SECONDARY_COLOR = '#1d1b31';

    /* ── Relationships ─────────────────────────────── */

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'organization_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'organization_id');
    }

    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class, 'organization_id');
    }

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class, 'organization_id');
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(AppVendor::class, 'organization_id');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'organization_id');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class, 'organization_id');
    }

    public function registries(): HasMany
    {
        return $this->hasMany(Registry::class, 'organization_id');
    }

    public function donors(): HasMany
    {
        return $this->hasMany(Donor::class, 'organization_id');
    }

    public function sponsors(): HasMany
    {
        return $this->hasMany(Sponsor::class, 'organization_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'organization_id');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'organization_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'organization_id');
    }

    public function communityPosts(): HasMany
    {
        return $this->hasMany(CommunityPost::class, 'organization_id');
    }

    public function solidApprovals(): HasMany
    {
        return $this->hasMany(SolidApproval::class, 'organization_id');
    }

    /* ── Accessors ─────────────────────────────────── */

    /**
     * Returns the resolved logo path (handles external URLs, uploads, and fallback).
     */
    public function getResolvedLogoAttribute(): string
    {
        if (empty($this->logo_url)) {
            return self::DEFAULT_LOGO;
        }

        if (str_starts_with($this->logo_url, 'http')) {
            return $this->logo_url;
        }

        return '/uploads/logos/' . $this->logo_url;
    }

    public function getResolvedPrimaryColorAttribute(): string
    {
        return $this->primary_color ?: self::DEFAULT_PRIMARY_COLOR;
    }

    public function getResolvedSecondaryColorAttribute(): string
    {
        return $this->secondary_color ?: self::DEFAULT_SECONDARY_COLOR;
    }
}
