<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolidApproval;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;

class SolidApprovalController extends Controller
{
    /**
     * Display a listing of SOLID approvals pending Stage 2 Admin review.
     */
    public function index(Request $request)
    {
        $admin = \App\Models\Admin::find(session('aid'));
        
        if ($request->ajax()) {
            $query = SolidApproval::with(['member', 'maintenance', 'staffReviewer'])
                ->where('organization_id', $admin->organization_id)
                ->where('status', 'pending_admin');
                
            return DataTables::of($query)
                ->addColumn('member', function ($a) {
                    $initial = strtoupper(substr($a->member->username ?? 'U', 0, 1));
                    $date = $a->created_at->format('M d, Y H:i');
                    $username = $a->member->username ?? 'Unknown';
                    return "<div class='flex items-center gap-3'>
                                <div class='w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shrink-0'>{$initial}</div>
                                <div>
                                    <h4 class='font-bold text-sm text-gray-900'>{$username}</h4>
                                    <span class='text-xs text-gray-500'>{$date}</span>
                                </div>
                            </div>";
                })
                ->addColumn('details', function ($a) {
                    $type = ucfirst($a->approval_type) . ' Approval';
                    $desc = htmlspecialchars($a->description);
                    $doc = $a->document_path ? "<a href='" . \Illuminate\Support\Facades\Storage::url($a->document_path) . "' target='_blank' class='text-[var(--primary)] text-xs mt-2 inline-block'><i class='bx bx-file'></i> View Attached Document</a>" : '';
                    return "<h5 class='font-bold text-gray-900 mb-1'>{$type}</h5>
                            <p class='text-gray-600 text-sm line-clamp-3'>{$desc}</p>
                            {$doc}";
                })
                ->addColumn('stage_1', function ($a) {
                    $reviewer = $a->staffReviewer->username ?? 'Staff';
                    $stage1 = $a->stage_1_staff_id 
                        ? "<span class='badge-status approved mb-1'><i class='bx bx-check'></i> Verified Stage 1</span><p class='text-xs text-gray-500 mt-1'>By: {$reviewer}</p>"
                        : "<span class='badge-status in_progress mb-1'><i class='bx bx-bolt-circle'></i> Auto-Skipped Stage 1</span>";
                    
                    $maintenance = '';
                    if ($a->maintenance_id && $a->maintenance) {
                        $fee = number_format($a->charge_amount, 2);
                        $isPaid = $a->maintenance->isPaid();
                        $color = $isPaid ? 'text-green-600' : 'text-red-600';
                        $status = $isPaid ? 'Paid' : 'Unpaid';
                        $maintenance = "<div class='mt-2 text-sm font-semibold'>Fee: ₹{$fee}</div><span class='text-xs font-bold {$color}'>{$status}</span>";
                    }
                    
                    return $stage1 . $maintenance;
                })
                ->addColumn('actions', function ($a) {
                    $approveUrl = route('admin.solid.approve', $a->id);
                    $rejectUrl = route('admin.solid.reject', $a->id);
                    $csrf = csrf_field();
                    
                    $approveBtn = (!$a->maintenance_id || ($a->maintenance && $a->maintenance->isPaid()))
                        ? "<form action='{$approveUrl}' method='POST' style='display:inline;'>{$csrf}<button type='submit' class='btn-modern btn-success btn-sm'><i class='bx bx-check-double'></i> Final Approve</button></form>"
                        : "<button disabled class='btn-modern btn-outline btn-sm opacity-50 cursor-not-allowed' title='Cannot approve until invoice is paid'><i class='bx bx-check-double'></i> Final Approve</button>";
                        
                    $rejectBtn = "<form action='{$rejectUrl}' method='POST' style='display:inline;'>{$csrf}<button type='submit' class='btn-modern btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to completely reject this SOLID request?\")'><i class='bx bx-x'></i> Reject</button></form>";
                    
                    return "<div class='flex gap-2'>" . $approveBtn . $rejectBtn . "</div>";
                })
                ->rawColumns(['member', 'details', 'stage_1', 'actions'])
                ->make(true);
        }
            
        return view('admin.solid.index');
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
