<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolidApproval;
use Illuminate\Support\Facades\Auth;

class SolidApprovalController extends Controller
{
    /**
     * Display a listing of SOLID approvals pending Stage 2 Admin review.
     */
    public function index()
    {
        $admin = \App\Models\Admin::find(session('aid'));
        
        $approvals = SolidApproval::with(['member', 'maintenance', 'staffReviewer'])
            ->where('organization_id', $admin->organization_id)
            ->where('status', 'pending_admin')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
            
        return view('admin.solid.index', compact('approvals'));
    }

    /**
     * Approve a SOLID request at Stage 2.
     */
    public function approve(Request $request, $id)
    {
        $admin = \App\Models\Admin::find(session('aid'));
        
        $approval = SolidApproval::where('organization_id', $admin->organization_id)
            ->where('status', 'pending_admin')
            ->findOrFail($id);
            
        $approval->update([
            'status' => 'approved',
            'stage_2_admin_id' => $admin->id
        ]);
        
        return back()->with('success', 'SOLID request fully approved and finalized.');
    }

    /**
     * Reject a SOLID request at Stage 2.
     */
    public function reject(Request $request, $id)
    {
        $admin = \App\Models\Admin::find(session('aid'));
        
        $approval = SolidApproval::where('organization_id', $admin->organization_id)
            ->where('status', 'pending_admin')
            ->findOrFail($id);
            
        $approval->update([
            'status' => 'rejected',
            'stage_2_admin_id' => $admin->id
        ]);
        
        return back()->with('success', 'SOLID request rejected.');
    }

    /**
     * Display settings to configure standard SOLID charges.
     */
    public function settings()
    {
        $organization = \App\Models\Admin::find(session('aid'))->organization;
        return view('admin.solid.settings', compact('organization'));
    }

    /**
     * Update SOLID charges settings.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'solid_sale_charge' => 'required|numeric|min:0',
            'solid_occupancy_charge' => 'required|numeric|min:0',
            'solid_lease_charge' => 'required|numeric|min:0',
            'solid_interior_charge' => 'required|numeric|min:0',
            'solid_decoration_charge' => 'required|numeric|min:0',
        ]);

        $organization = \App\Models\Admin::find(session('aid'))->organization;
        
        $organization->update([
            'solid_sale_charge' => $request->solid_sale_charge,
            'solid_occupancy_charge' => $request->solid_occupancy_charge,
            'solid_lease_charge' => $request->solid_lease_charge,
            'solid_interior_charge' => $request->solid_interior_charge,
            'solid_decoration_charge' => $request->solid_decoration_charge,
        ]);

        return back()->with('success', 'SOLID default charges updated successfully.');
    }
}
