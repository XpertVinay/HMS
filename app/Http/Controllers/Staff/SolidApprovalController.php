<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolidApproval;
use Illuminate\Support\Facades\Auth;

class SolidApprovalController extends Controller
{
    /**
     * Display a listing of SOLID approvals pending Stage 1 staff review.
     */
    public function index()
    {
        $staff = \App\Models\Staff::find(session('aid'));
        
        $approvals = SolidApproval::with(['member', 'maintenance'])
            ->where('organization_id', $staff->organization_id)
            ->where('status', 'pending_staff')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
            
        return view('staff.solid.index', compact('approvals'));
    }

    /**
     * Approve a SOLID request at Stage 1 and move to Stage 2.
     */
    public function approve(Request $request, $id)
    {
        $staff = \App\Models\Staff::find(session('aid'));
        
        $approval = SolidApproval::where('organization_id', $staff->organization_id)
            ->where('status', 'pending_staff')
            ->findOrFail($id);
            
        // Check if invoice is paid before approving (optional business rule, enforcing it here)
        if ($approval->maintenance_id && !$approval->maintenance->isPaid()) {
            return back()->with('error', 'Cannot approve! The member has not paid the required SOLID processing fee yet.');
        }
            
        $approval->update([
            'status' => 'pending_admin',
            'stage_1_staff_id' => $staff->id
        ]);
        
        return back()->with('success', 'SOLID request approved at Stage 1. It has been sent to Admin for final approval.');
    }

    /**
     * Reject a SOLID request at Stage 1.
     */
    public function reject(Request $request, $id)
    {
        $staff = \App\Models\Staff::find(session('aid'));
        
        $approval = SolidApproval::where('organization_id', $staff->organization_id)
            ->where('status', 'pending_staff')
            ->findOrFail($id);
            
        $approval->update([
            'status' => 'rejected',
            'stage_1_staff_id' => $staff->id
        ]);
        
        return back()->with('success', 'SOLID request rejected.');
    }
}
