<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorAdvertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();
        
        $advertisements = VendorAdvertisement::whereHas('vendor.alignments', function($q) use ($orgId) {
                $q->where('organization_id', $orgId);
            })
            ->with('vendor')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.advertisements.index', compact('advertisements'));
    }

    public function approve($id)
    {
        $orgId = $this->orgId();
        $ad = VendorAdvertisement::whereHas('vendor.alignments', function($q) use ($orgId) {
            $q->where('organization_id', $orgId);
        })->findOrFail($id);

        $ad->status = 'active';
        $ad->save();

        return redirect()->back()->with('success', 'Advertisement approved successfully.');
    }

    public function reject($id)
    {
        $orgId = $this->orgId();
        $ad = VendorAdvertisement::whereHas('vendor.alignments', function($q) use ($orgId) {
            $q->where('organization_id', $orgId);
        })->findOrFail($id);

        $ad->status = 'rejected';
        $ad->save();

        return redirect()->back()->with('success', 'Advertisement rejected.');
    }
}
