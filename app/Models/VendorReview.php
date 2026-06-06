<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorReview extends Model
{
    protected $fillable = ['vendor_id', 'member_id', 'rating', 'review_text'];

    public function vendor()
    {
        return $this->belongsTo(AppVendor::class, 'vendor_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
