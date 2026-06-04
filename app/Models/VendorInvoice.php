<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorInvoice extends Model
{
    protected $table = 'vendor_invoice';

    protected $fillable = [
        'vendor_id',
        'invoice_file',
        'amount',
        'organization_id',
        'status',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(AppVendor::class, 'vendor_id');
    }
}
