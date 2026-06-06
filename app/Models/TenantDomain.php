<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Maps custom domains and subdomains to organizations.
 *
 * Examples:
 *   domain = 'myrwa.com'                 → Organization #3
 *   subdomain = 'green-valley'           → green-valley.rcms.businzo.com → Organization #5
 *   domain = 'community.network.com'     → Organization #7
 */
class TenantDomain extends Model
{
    protected $fillable = [
        'organization_id',
        'domain',
        'subdomain',
        'is_primary',
        'is_verified',
        'verified_at',
        'ssl_status',
    ];

    protected $casts = [
        'is_primary'  => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /* ── Relationships ─────────────────────────────── */

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /* ── Scoped Queries ────────────────────────────── */

    /**
     * Find the organization for a full custom domain (e.g. myrwa.com).
     */
    public static function resolveByDomain(string $domain): ?self
    {
        return static::where('domain', $domain)
                     ->where('is_verified', true)
                     ->first();
    }

    /**
     * Find the organization for a subdomain prefix (e.g. green-valley).
     */
    public static function resolveBySubdomain(string $subdomain): ?self
    {
        return static::where('subdomain', $subdomain)->first();
    }

    /**
     * Get the primary domain record for an organization.
     */
    public static function primaryFor(int $organizationId): ?self
    {
        return static::where('organization_id', $organizationId)
                     ->where('is_primary', true)
                     ->first();
    }
}
