<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantScoped;
class ServiceBooking extends Model {
    use TenantScoped;
    protected $fillable = ['organization_id', 'member_id', 'vendor_service_id', 'start_date', 'end_date', 'status', 'payment_method', 'total_amount', 'closing_remarks'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];
    public function member() { return $this->belongsTo(Member::class, 'member_id'); }
    public function vendorService() { return $this->belongsTo(VendorService::class, 'vendor_service_id'); }
    public function commission() { return $this->hasOne(PlatformCommission::class, 'service_booking_id'); }
}
