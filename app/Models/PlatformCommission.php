<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PlatformCommission extends Model {
    protected $fillable = ['service_booking_id', 'organization_id', 'vendor_id', 'total_booking_amount', 'commission_percentage', 'commission_amount', 'status'];
    public function booking() { return $this->belongsTo(ServiceBooking::class, 'service_booking_id'); }
    public function organization() { return $this->belongsTo(Organization::class, 'organization_id'); }
    public function vendor() { return $this->belongsTo(AppVendor::class, 'vendor_id'); }
}
