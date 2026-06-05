<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class Registry extends Model
{
    use TenantScoped;

    protected $table = 'registry';

    protected $fillable = [
        'visitor_name',
        'host_id',
        'visitor_contact',
        'purpose',
        'status',
        'out_time',
        'organization_id',
    ];

    protected $casts = [
        'out_time' => 'datetime',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'host_id');
    }
}
