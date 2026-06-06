<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class MaintenanceItem extends Model
{
    use TenantScoped;

    protected $table = 'maintenance_items';
    public $timestamps = false;

    protected $fillable = [
        'maintenance_id',
        'type',
        'reading',
        'consumption',
        'rate',
        'previous_reading',
        'previous_consumption',
        'amount',
        'previous_amount',
        'organization_id',
    ];

    protected $casts = [
        'type' => 'integer',
        'rate' => 'float',
        'amount' => 'float',
        'previous_amount' => 'float',
    ];

    /**
     * Bill type labels: 1 = Block Rent, 2 = Electricity, 3 = Water.
     */
    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            1 => 'Block Rent',
            2 => 'Electricity',
            3 => 'Water',
            default => 'Other',
        };
    }

    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class, 'maintenance_id');
    }
}
