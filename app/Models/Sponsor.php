<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class Sponsor extends Model
{
    use TenantScoped;

    protected $table = 'sponsors';

    protected $fillable = [
        'name',
        'logo_url',
        'description',
        'website_url',
        'organization_id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
