<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\AppVendor;
use Illuminate\Http\Request;

class VendorDirectoryController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();
        
        $vendors = AppVendor::whereHas('alignments', function($q) use ($orgId) {
                $q->where('organization_id', $orgId)->where('status', 'approved');
            })
            ->withCount('reviews')
            ->paginate(15);

        return view('member.vendors.directory', compact('vendors'));
    }

    public function show($id)
    {
        $orgId = $this->orgId();
        
        $vendor = AppVendor::whereHas('alignments', function($q) use ($orgId) {
                $q->where('organization_id', $orgId)->where('status', 'approved');
            })
            ->with(['reviews.member', 'advertisements' => function($q) {
                $q->where('status', 'active');
            }])
            ->findOrFail($id);
            
        $averageRating = collect($vendor->reviews)->avg('rating') ?: 0;

        return view('member.vendors.show', compact('vendor', 'averageRating'));
    }
}
