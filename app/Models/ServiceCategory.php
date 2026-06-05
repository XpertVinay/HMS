<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ServiceCategory extends Model {
    protected $fillable = ['name', 'slug', 'icon', 'is_active'];
    public function vendorServices() {
        return $this->hasMany(VendorService::class, 'service_category_id');
    }
}
