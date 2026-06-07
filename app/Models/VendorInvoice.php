<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class VendorInvoice extends Model
{
    use TenantScoped;

    protected $table = 'vendor_invoice';

    protected $fillable = [
        'vendor_id',
        'invoice_file',
        'amount',
        'organization_id',
        'status',
        'ticket_id',
        'task_details',
        'member_id',
        'resident_id',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(AppVendor::class, 'vendor_id');
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}
