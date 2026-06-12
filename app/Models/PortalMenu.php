<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortalMenu extends Model
{
    protected $fillable = [
        'organization_id',
        'parent_id',
        'title',
        'url',
        'type',
        'order',
        'target',
        'visibility',
        'roles',
        'permissions',
        'icon',
        'route_name',
        'is_preset',
    ];

    protected $casts = [
        'roles' => 'array',
        'permissions' => 'array',
        'is_preset' => 'boolean',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function parent()
    {
        return $this->belongsTo(PortalMenu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PortalMenu::class, 'parent_id')->orderBy('order');
    }
}
