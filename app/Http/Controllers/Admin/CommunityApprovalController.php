<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunityPost;
use Illuminate\Support\Facades\Auth;

class CommunityApprovalController extends Controller
{
    /**
     * Display a listing of posts requiring Stage 2 (Final) approval.
     */
    public function index()
    {
        $admin = \App\Models\Admin::find(session('aid'));
        
        $posts = CommunityPost::with(['member', 'staffReviewer'])
            ->where('organization_id', $admin->organization_id)
            ->where('status', 'pending_stage_2')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
            
        return view('admin.community.approvals', compact('posts'));
    }

    /**
     * Final approval of a post. It will now be visible in the Community Feed.
     */
    public function approve(Request $request, $id)
    {
        $admin = \App\Models\Admin::find(session('aid'));
        
        $post = CommunityPost::where('organization_id', $admin->organization_id)
            ->where('status', 'pending_stage_2')
            ->findOrFail($id);
            
        $post->update([
            'status' => 'approved',
            'stage_2_admin_id' => $admin->id
        ]);
        
        return back()->with('success', 'Post successfully approved! It is now live in the Community Feed.');
    }

    /**
     * Reject a post at Stage 2.
     */
    public function reject(Request $request, $id)
    {
        $admin = \App\Models\Admin::find(session('aid'));
        
        $post = CommunityPost::where('organization_id', $admin->organization_id)
            ->where('status', 'pending_stage_2')
            ->findOrFail($id);
            
        $post->update([
            'status' => 'rejected',
            'stage_2_admin_id' => $admin->id
        ]);
        
        return back()->with('success', 'Post rejected. It will not be published.');
    }
}
