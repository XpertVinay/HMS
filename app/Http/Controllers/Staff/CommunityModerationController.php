<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunityPost;
use App\Models\Admin;
use App\Notifications\PostRequiresStage2Approval;
use Illuminate\Support\Facades\Auth;

use Yajra\DataTables\Facades\DataTables;

class CommunityModerationController extends Controller
{
    /**
     * Display a listing of posts requiring Stage 1 approval.
     */
    public function index(Request $request)
    {
        $staff = \App\Models\Staff::find(session('aid'));
        
        if ($request->ajax()) {
            $query = CommunityPost::with('member')
                ->where('organization_id', $staff->organization_id)
                ->where('status', 'pending_stage_1');
                
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('member', function ($p) {
                    return $p->member->username ?? 'Unknown';
                })
                ->addColumn('content', function ($p) {
                    return \Illuminate\Support\Str::limit($p->content, 100);
                })
                ->addColumn('date', function ($p) {
                    return $p->created_at ? $p->created_at->format('M d, Y H:i') : '-';
                })
                ->addColumn('actions', function ($p) {
                    $approveUrl = route('staff.community.approve', $p->id);
                    $rejectUrl = route('staff.community.reject', $p->id);
                    $csrf = csrf_field();
                    
                    return "<form action='{$approveUrl}' method='POST' style='display:inline;'>
                                {$csrf}
                                <button type='submit' class='btn-modern btn-sm btn-success' onclick='return confirm(\"Approve this post for Stage 2?\")'>Approve</button>
                            </form>
                            <form action='{$rejectUrl}' method='POST' style='display:inline;'>
                                {$csrf}
                                <button type='submit' class='btn-modern btn-sm btn-danger' onclick='return confirm(\"Reject this post?\")'>Reject</button>
                            </form>";
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
            
        return view('staff.community.moderation');
    }

    /**
     * Approve a post at Stage 1 and move to Stage 2.
     */
    public function approve(Request $request, $id)
    {
        $staff = \App\Models\Staff::find(session('aid'));
        
        $post = CommunityPost::where('organization_id', $staff->organization_id)
            ->where('status', 'pending_stage_1')
            ->findOrFail($id);
            
        $post->update([
            'status' => 'pending_stage_2',
            'stage_1_staff_id' => $staff->id
        ]);
        
        // Notify Admin for Stage 2
        $admins = Admin::where('organization_id', $staff->organization_id)->get();
        foreach ($admins as $admin) {
            $admin->notify(new PostRequiresStage2Approval($post));
        }
        
        return back()->with('success', 'Post approved at Stage 1. It has been sent to the Admin for final approval.');
    }

    /**
     * Reject a post at Stage 1.
     */
    public function reject(Request $request, $id)
    {
        $staff = \App\Models\Staff::find(session('aid'));
        
        $post = CommunityPost::where('organization_id', $staff->organization_id)
            ->where('status', 'pending_stage_1')
            ->findOrFail($id);
            
        $post->update([
            'status' => 'rejected',
            'stage_1_staff_id' => $staff->id
        ]);
        
        return back()->with('success', 'Post rejected. It will not be published.');
    }
}
