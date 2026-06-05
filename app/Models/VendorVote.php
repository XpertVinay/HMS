<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class VendorVote extends Model {
    protected $fillable = ['rwa_vendor_alignment_id', 'member_id', 'vote'];
    public function alignment() { return $this->belongsTo(RwaVendorAlignment::class, 'rwa_vendor_alignment_id'); }
    public function member() { return $this->belongsTo(Member::class, 'member_id'); }
}
