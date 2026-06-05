<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class VendorAdvertisement extends Model {
    protected $fillable = ['vendor_id', 'title', 'description', 'image_url', 'target_url', 'status', 'advertisement_fee', 'expires_at'];
    protected $casts = ['expires_at' => 'datetime'];
    public function vendor() { return $this->belongsTo(AppVendor::class, 'vendor_id'); }
}
