<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolidApproval;
use App\Services\SolidApprovalService;
use Illuminate\Support\Facades\Auth;

class SolidApprovalController extends Controller
{
    /**
     * Display a listing of the member's SOLID approval requests.
     */
    public function index()
    {
        $member = \App\Models\Member::find(session('uid'));
        
        $approvals = SolidApproval::with('maintenance')
            ->where('member_id', $member->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('member.solid.index', compact('approvals'));
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
