<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class RwaVendorAlignment extends Model {
    protected $fillable = ['organization_id', 'vendor_id', 'status', 'voting_ends_at'];
    protected $casts = ['voting_ends_at' => 'datetime'];
    public function vendor() { return $this->belongsTo(AppVendor::class, 'vendor_id'); }
    public function organization() { return $this->belongsTo(Organization::class, 'organization_id'); }
    public function votes() { return $this->hasMany(VendorVote::class, 'rwa_vendor_alignment_id'); }
}
