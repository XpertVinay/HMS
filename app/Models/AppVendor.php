<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Named AppVendor to avoid conflict with PHP's built-in Vendor namespace.
 * Maps to the 'vendor' table.
 */
class AppVendor extends Authenticatable
{
    protected $table = 'vendor';

    const UPDATED_AT = null;

    protected $fillable = [
        'business_name',
        'email',
        'password',
        'business_registration',
        'organization_id',
        'bank_account_details',
        'is_gst_verified_staff',
        'is_gst_verified_admin',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_gst_verified_staff' => 'boolean',
        'is_gst_verified_admin' => 'boolean',
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

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(VendorInvoice::class, 'vendor_id');
    }
}
