<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Maps to the 'contacts' table.
 * This table is responsible for storing leads and contacts.
 */
class Contacts extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'service',
        'message',
        'is_contacted'
    ];

}
