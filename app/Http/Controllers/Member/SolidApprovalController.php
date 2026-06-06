<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolidApproval;
use App\Services\SolidApprovalService;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;

class SolidApprovalController extends Controller
{
    /**
     * Display a listing of the member's SOLID approval requests.
     */
    public function index(Request $request)
    {
        $member = \App\Models\Member::find(session('uid'));
        
        if ($request->ajax()) {
            $query = SolidApproval::with('maintenance')
                ->where('member_id', $member->id);
                
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('details', function ($a) {
                    $html = '<h5 class="font-bold text-gray-900 mb-1 capitalize">' . $a->approval_type . ' Approval</h5>';
                    $html .= '<p class="text-gray-600 text-sm">' . \Illuminate\Support\Str::limit($a->description, 100) . '</p>';
                    return $html;
                })
                ->addColumn('date', function ($a) {
                    return $a->created_at ? $a->created_at->format('M d, Y') : '-';
                })
                ->addColumn('fee_status', function ($a) {
                    if($a->maintenance_id) {
                        $html = '<div class="font-semibold text-gray-900">₹' . number_format($a->charge_amount, 2) . '</div>';
                        if($a->maintenance->isPaid()) {
                            $html .= '<span class="badge-status paid mt-1"><i class="bx bx-check"></i> Paid</span>';
                        } else {
                            $html .= '<span class="badge-status unpaid mt-1"><i class="bx bx-x"></i> Unpaid</span>';
                            $payUrl = route('member.maintenance.show', $a->maintenance_id);
                            $html .= '<br><a href="' . $payUrl . '" class="text-[var(--primary)] text-xs font-bold hover:underline">Pay Now</a>';
                        }
                        return $html;
                    }
                    return '<span class="text-gray-500">No Charge</span>';
                })
                ->addColumn('status', function ($a) {
                    if($a->status === 'approved') return '<span class="badge-status approved"><i class="bx bx-check-double"></i> Approved</span>';
                    if($a->status === 'rejected') return '<span class="badge-status rejected"><i class="bx bx-x"></i> Rejected</span>';
                    if($a->status === 'pending_staff') return '<span class="badge-status pending"><i class="bx bx-time"></i> Verification Pending (Staff)</span>';
                    if($a->status === 'pending_admin') return '<span class="badge-status pending"><i class="bx bx-time"></i> Approval Pending (Admin)</span>';
                    return ucfirst($a->status);
                })
                ->rawColumns(['details', 'fee_status', 'status'])
                ->make(true);
        }
            
        return view('member.solid.index');
    }

    /**
     * Show the form for creating a new request.
     */
    public function create()
    {
        $organization = \App\Models\Member::find(session('uid'))->organization;
        return view('member.solid.create', compact('organization'));
    }

    /**
     * Store a newly created request using the Service (SOLID principles).
     */
    public function store(Request $request, SolidApprovalService $solidService)
    {
        $request->validate([
            'approval_type' => 'required|in:sale,occupancy,lease,interior,decoration',
            'description' => 'required|string',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $member = \App\Models\Member::find(session('uid'));

        // Handle Document
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('solid_documents', 'public');
        }

        // Delegate to service
        $solidService->submitRequest(
            $member,
            $request->approval_type,
            $request->description,
            $documentPath
        );

        return redirect()->route('member.solid.index')
            ->with('success', 'Approval request submitted successfully. An invoice has been generated for the charges.');
    }
}
