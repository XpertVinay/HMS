<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunityPost;
use App\Models\Admin;
use App\Notifications\PostRequiresStage2Approval;
use Illuminate\Support\Facades\Auth;

class CommunityModerationController extends Controller
{
    /**
     * Display a listing of posts requiring Stage 1 approval.
     */
    public function index()
    {
        $staff = \App\Models\Staff::find(session('aid'));
        
        $posts = CommunityPost::with('member')
            ->where('organization_id', $staff->organization_id)
            ->where('status', 'pending_stage_1')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
            
        return view('staff.community.moderation', compact('posts'));
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
