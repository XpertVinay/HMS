<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\TenantScoped;

class CommunityPost extends Model
{
    use HasFactory, TenantScoped;

    protected $table = 'community_posts';

    protected $fillable = [
        'organization_id',
        'member_id',
        'title',
        'content',
        'image_path',
        'status',
        'ai_score',
        'ai_feedback',
        'stage_1_staff_id',
        'stage_2_admin_id'
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
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
