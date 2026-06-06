<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\TenantScoped;

class Gallery extends Model
{
    use TenantScoped;

    protected $table = 'gallery';
    const CREATED_AT = 'uploaded_at';

    protected $fillable = [
        'title',
        'image_url',
        'description',
        'organization_id',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
}
