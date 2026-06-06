<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class VendorService extends Model {
    protected $fillable = ['vendor_id', 'service_category_id', 'title', 'description', 'price', 'pricing_type', 'is_active'];
    public function vendor() { return $this->belongsTo(AppVendor::class, 'vendor_id'); }
    public function category() { return $this->belongsTo(ServiceCategory::class, 'service_category_id'); }
}
