<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class Ticket extends Model
{
    use TenantScoped;

    protected $table = 'tickets';

    protected $fillable = [
        'organization_id',
        'member_id',
        'resident_id',
        'subject',
        'description',
        'category',
        'status',
        'response',
        'assigned_vendor_id',
        'vendor_invoice_amount',
        'vendor_invoice_file',
        'vendor_approval_status',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(AppVendor::class, 'assigned_vendor_id');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class, 'ticket_id');
    }
}
