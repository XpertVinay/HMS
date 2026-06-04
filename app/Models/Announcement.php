<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $table = 'announcement';
    protected $primaryKey = 'announcement_id';

    protected $fillable = [
        'announcement_subject',
        'announcement_text',
        'announcement_status',
        'organization_id',
    ];

    protected $casts = [
        'announcement_status' => 'integer',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
