<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IndustryMenuPreset extends Model
{
    use HasFactory;

    protected $fillable = [
        'industry_id',
        'menu_hierarchy',
    ];

    protected $casts = [
        'menu_hierarchy' => 'array',
    ];

    public function industry(): BelongsTo
    {
        return $this->belongsTo(Industry::class);
    }
}
