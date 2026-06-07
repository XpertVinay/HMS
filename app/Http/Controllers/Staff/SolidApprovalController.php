<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolidApproval;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;

class SolidApprovalController extends Controller
{
    /**
     * Display a listing of SOLID approvals pending Stage 1 staff review.
     */
    public function index(Request $request)
    {
        $staff = \App\Models\Staff::find(session('aid'));
        
        if ($request->ajax()) {
            $query = SolidApproval::with(['member', 'maintenance'])
                ->where('solid_approvals.organization_id', $staff->organization_id)
                ->where('solid_approvals.status', 'pending_staff');
                
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('member', function ($a) {
                    return $a->member->username ?? 'Unknown';
                })
                ->addColumn('details', function ($a) {
                    $html = '<div><strong>Fee:</strong> ₹' . number_format($a->maintenance->total_amount ?? 0, 2) . '</div>';
                    $paidStatus = ($a->maintenance && $a->maintenance->isPaid()) 
                                    ? '<span class="text-green-600 font-bold">Paid</span>' 
                                    : '<span class="text-red-600 font-bold">Unpaid</span>';
                    $html .= '<div><strong>Payment:</strong> ' . $paidStatus . '</div>';
                    return $html;
                })
                ->addColumn('date', function ($a) {
                    return $a->created_at ? $a->created_at->format('M d, Y') : '-';
                })
                ->addColumn('actions', function ($a) {
                    $approveUrl = route('staff.solid.approve', $a->id);
                    $rejectUrl = route('staff.solid.reject', $a->id);
                    $csrf = csrf_field();
                    
                    return "<form action='{$approveUrl}' method='POST' style='display:inline;'>
                                {$csrf}
                                <button type='submit' class='btn-modern btn-sm btn-success' onclick='return confirm(\"Approve this request for Stage 2?\")'>Approve</button>
                            </form>
                            <form action='{$rejectUrl}' method='POST' style='display:inline;'>
                                {$csrf}
                                <button type='submit' class='btn-modern btn-sm btn-danger' onclick='return confirm(\"Reject this request?\")'>Reject</button>
                            </form>";
                })
                ->rawColumns(['details', 'actions'])
                ->make(true);
        }
            
        return view('staff.solid.index');
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
