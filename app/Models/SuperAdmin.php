<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuperAdmin extends Authenticatable
{
    protected $table = 'super_admin';

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    /**
     * Super admins are global — not scoped to any organization.
     */
    public function getRoleAttribute(): string
    {
        return 'super_admin';
    }
}
