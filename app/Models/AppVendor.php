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

    protected $fillable = [
        'business_name',
        'email',
        'password',
        'business_registration',
        'bank_account_details',
        'is_gst_verified_staff',
        'is_gst_verified_admin',
        'global_rating',
        'total_tasks_completed',
        'is_active_globally',
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

    /**
     * Vendors are now global — organization alignment is via rwa_vendor_alignments table.
     */

    public function invoices(): HasMany
    {
        return $this->hasMany(VendorInvoice::class, 'vendor_id');
    }
}
