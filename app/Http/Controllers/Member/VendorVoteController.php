<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\RwaVendorAlignment;
use App\Models\VendorVote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorVoteController extends Controller
{
    public function index()
    {
        // Get all alignments that are currently in voting phase
        $alignments = RwaVendorAlignment::with(['vendor', 'votes'])
            ->where('organization_id', app('active_org')->id)
            ->where('status', 'voting')
            ->where('voting_ends_at', '>', now())
            ->get();
            
        $memberId = session('uid');

        return view('member.vendor_votes.index', compact('alignments', 'memberId'));
    }

    public function castVote(Request $request, $alignment_id)
    {
        $request->validate(['vote' => 'required|in:approve,reject']);
        
        $alignment = RwaVendorAlignment::where('organization_id', app('active_org')->id)
            ->where('status', 'voting')
            ->findOrFail($alignment_id);
            
        VendorVote::updateOrCreate(
            ['rwa_vendor_alignment_id' => $alignment->id, 'member_id' => session('uid')],
            ['vote' => $request->vote]
        );

        return redirect()->back()->with('success', 'Your vote has been cast!');
    }
}
