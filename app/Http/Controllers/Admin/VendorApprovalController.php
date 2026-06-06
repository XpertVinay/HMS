<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RwaVendorAlignment;
use Illuminate\Http\Request;

class VendorApprovalController extends Controller
{
    public function index()
    {
        // View alignments that are proposed, in voting, or finished voting
        $alignments = RwaVendorAlignment::with(['vendor', 'votes'])
            ->where('organization_id', app('active_org')->id)
            ->get();

        return view('admin.vendor_approvals.index', compact('alignments'));
    }

    public function approve(Request $request, $id)
    {
        $alignment = RwaVendorAlignment::where('organization_id', app('active_org')->id)->findOrFail($id);
        
        $alignment->update([
            'status' => 'admin_approved',
            // It is now an active vendor for this RWA
        ]);
        
        // Let's actually set status to active to make it immediately available for services
        $alignment->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Vendor is now Active for this RWA. Members can now book their services.');
    }

    public function reject(Request $request, $id)
    {
        $alignment = RwaVendorAlignment::where('organization_id', app('active_org')->id)->findOrFail($id);
        
        $alignment->update([
            'status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Vendor alignment rejected.');
    }
}
