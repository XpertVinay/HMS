<?php

namespace App\Models;

use App\Traits\HasPersonName;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Named AppVendor to avoid conflict with PHP's built-in Vendor namespace.
 * Maps to the 'vendor' table.
 */
class AppVendor extends Authenticatable implements JWTSubject
{
    use HasPersonName;

    protected $table = 'vendor';

    protected $fillable = [
        'business_name',
        'first_name',
        'last_name',
        'email',
        'password',
        'business_registration',
        'bank_account_details',
        'is_gst_verified_staff',
        'is_gst_verified_admin',
        'global_rating',
        'total_tasks_completed',
        'is_active_globally',
        'is_featured',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_gst_verified_staff' => 'boolean',
        'is_gst_verified_admin' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function getAccountTypeAttribute(): string
    {
        return 'vendor';
    }

    /**
     * Vendor uses business_name as the username field.
     */
    public function getUsernameAttribute(): string
    {
        return $this->business_name;
    }

    /**
     * Vendors are now global — organization alignment is via rwa_vendor_alignments table.
     */

    public function invoices(): HasMany
    {
        return $this->hasMany(VendorInvoice::class, 'vendor_id');
    }

    public function alignments(): HasMany
    {
        return $this->hasMany(RwaVendorAlignment::class, 'vendor_id');
    }

    public function advertisements(): HasMany
    {
        return $this->hasMany(VendorAdvertisement::class, 'vendor_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(VendorReview::class, 'vendor_id');
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
            'role' => 'vendor'
        ];
    }
}
