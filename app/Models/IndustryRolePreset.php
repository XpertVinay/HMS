<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndustryRolePreset extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'role_name',
        'default_permissions',
    ];

    protected $casts = [
        'default_permissions' => 'array',
    ];

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }
}
