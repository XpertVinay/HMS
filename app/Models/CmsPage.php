<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'slug',
        'html',
        'css',
        'gjs_data',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
