<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class Property extends Model
{
    use TenantScoped;

    protected $table = 'property';

    protected $fillable = [
        'unit_number',
        'street_area',
        'locality_village',
        'city_town',
        'district',
        'state',
        'pincode',
        'address_metadata',
        'type',
        'owner_id',
        'organization_id',
        'resident_id',
    ];

    protected $casts = [
        'address_metadata' => 'array',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'owner_id');
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }
}
