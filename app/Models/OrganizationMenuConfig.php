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
        'menu_hierarchy',
    ];

    protected $casts = [
        'enabled_menus' => 'array',
        'menu_hierarchy' => 'array',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    protected static function booted()
    {
        static::saved(function ($config) {
            \Illuminate\Support\Facades\Cache::forget("org_{$config->organization_id}_menu_hierarchy");
        });

        static::deleted(function ($config) {
            \Illuminate\Support\Facades\Cache::forget("org_{$config->organization_id}_menu_hierarchy");
        });
    }
}
