<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingRwaRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_name',
        'org_address',
        'registration_code',
        'subdomain',
        'admin_username',
        'admin_first_name',
        'admin_last_name',
        'admin_email',
        'admin_password',
        'fee_amount',
        'status',
        'industry_id',
        'selected_features',
        'platform_fee',
        'feature_fee',
    ];

    protected $casts = [
        'selected_features' => 'array',
        'platform_fee' => 'decimal:2',
        'feature_fee' => 'decimal:2',
        'fee_amount' => 'decimal:2',
    ];

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
