<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorReview;
use App\Models\AppVendor;

class ReviewController extends Controller
{
    public function index()
    {
        $vendor = AppVendor::find(session('uid'));
        
        $reviews = VendorReview::where('vendor_id', $vendor->id)
            ->with('member')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $averageRating = $vendor->global_rating;
        $totalReviews = VendorReview::where('vendor_id', $vendor->id)->count();

        return view('vendor.reviews.index', compact('reviews', 'averageRating', 'totalReviews'));
    }
}
