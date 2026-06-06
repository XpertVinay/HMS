<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\AppVendor;
use App\Models\RwaVendorAlignment;
use Illuminate\Http\Request;

class VendorAlignmentController extends Controller
{
    public function index()
    {
        // Show all vendors that are proposed, voting, or active for this organization
        $alignments = RwaVendorAlignment::with('vendor')
            ->where('organization_id', app('active_org')->id)
            ->get();

        // Also get list of global vendors not yet proposed
        $alignedVendorIds = $alignments->pluck('vendor_id')->toArray();
        $globalVendors = AppVendor::where('is_active_globally', true)
            ->whereNotIn('id', $alignedVendorIds)
            ->orderBy('global_rating', 'desc')
            ->get();

        return view('staff.vendor_alignments.index', compact('alignments', 'globalVendors'));
    }

    public function propose(Request $request)
    {
        $request->validate(['vendor_id' => 'required|exists:vendor,id']);

        RwaVendorAlignment::create([
            'organization_id' => app('active_org')->id,
            'vendor_id' => $request->vendor_id,
            'status' => 'proposed',
        ]);

        return redirect()->back()->with('success', 'Vendor proposed successfully. Wait for Admin/Member review.');
    }
    
    public function startVoting(Request $request, $id)
    {
        $alignment = RwaVendorAlignment::where('organization_id', app('active_org')->id)->findOrFail($id);
        $alignment->update([
            'status' => 'voting',
            'voting_ends_at' => now()->addDays(7),
        ]);
        
        return redirect()->back()->with('success', 'Voting started for 7 days.');
    }
}
