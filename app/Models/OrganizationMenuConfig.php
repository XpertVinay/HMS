<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationMenuConfig extends Model
{
    protected $table = 'organization_menu_configs';

    protected $fillable = [
        'organization_id',
        'enabled_menus',
    ];

    protected $casts = [
        'enabled_menus' => 'array',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
