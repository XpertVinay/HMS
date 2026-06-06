<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\TenantScoped;

class SolidApproval extends Model
{
    use HasFactory, TenantScoped;

    protected $table = 'solid_approvals';

    protected $fillable = [
        'organization_id',
        'member_id',
        'approval_type',
        'status',
        'description',
        'charge_amount',
        'maintenance_id',
        'stage_1_staff_id',
        'stage_2_admin_id',
        'document_path'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class, 'maintenance_id');
    }

    public function staffReviewer(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'stage_1_staff_id');
    }
    
    public function adminReviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'stage_2_admin_id');
    }
}
