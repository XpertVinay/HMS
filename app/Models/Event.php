<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class Event extends Model
{
    use TenantScoped;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_time',
        'organization_id',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'datetime:H:i',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
