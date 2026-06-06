<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\VendorReview;
use Illuminate\Http\Request;

class VendorReviewController extends Controller
{
    public function store(Request $request, $vendorId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        $memberId = session('uid');

        $existing = VendorReview::where('vendor_id', $vendorId)
            ->where('member_id', $memberId)
            ->first();

        if ($existing) {
            return redirect()->back()->withErrors(['review' => 'You have already reviewed this vendor.']);
        }

        VendorReview::create([
            'vendor_id' => $vendorId,
            'member_id' => $memberId,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
}
