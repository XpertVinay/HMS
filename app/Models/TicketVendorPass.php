<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketVendorPass extends Model
{
    protected $table = 'ticket_vendor_passes';

    protected $fillable = [
        'ticket_id',
        'vendor_id',
        'comment',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(AppVendor::class, 'vendor_id');
    }
}
