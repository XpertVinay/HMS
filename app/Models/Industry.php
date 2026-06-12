<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_fee',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'base_fee' => 'decimal:2',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(IndustryFeature::class);
    }

    public function rolePresets(): HasMany
    {
        return $this->hasMany(IndustryRolePreset::class);
    }

    public function menuPreset()
    {
        return $this->hasOne(IndustryMenuPreset::class);
    }
}
