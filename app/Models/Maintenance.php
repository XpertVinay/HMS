<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\TenantScoped;

class Maintenance extends Model
{
    use TenantScoped;

    protected $table = 'maintenance';
    public $timestamps = false;

    protected $fillable = [
        'billing_date',
        'member_id',
        'status',
        'total_amount',
        'amount_payed',
        'amount_change',
        'invoice',
        'comment',
        'organization_id',
    ];

    protected $casts = [
        'billing_date' => 'datetime',
        'status' => 'integer',
        'total_amount' => 'float',
        'amount_payed' => 'float',
        'amount_change' => 'float',
    ];

    public function isPaid(): bool
    {
        return $this->status === 1;
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MaintenanceItem::class, 'maintenance_id');
    }
}
