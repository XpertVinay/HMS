<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $fillable = ['ticket_id', 'sender_id', 'sender_type', 'message', 'attachment_url'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
