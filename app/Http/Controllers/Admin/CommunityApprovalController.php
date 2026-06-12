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
        $orgId = $this->orgId();
        
        $posts = CommunityPost::with(['member', 'staffReviewer'])
            ->where('organization_id', $orgId)
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
        $orgId = $this->orgId();
        $adminId = session('aid'); // Will be null for super admins
        
        $post = CommunityPost::where('organization_id', $orgId)
            ->where('status', 'pending_stage_2')
            ->findOrFail($id);
            
        $post->update([
            'status' => 'approved',
            'stage_2_admin_id' => $adminId
        ]);
        
        return back()->with('success', 'Post successfully approved! It is now live in the Community Feed.');
    }

    /**
     * Reject a post at Stage 2.
     */
    public function reject(Request $request, $id)
    {
        $orgId = $this->orgId();
        $adminId = session('aid');
        
        $post = CommunityPost::where('organization_id', $orgId)
            ->where('status', 'pending_stage_2')
            ->findOrFail($id);
            
        $post->update([
            'status' => 'rejected',
            'stage_2_admin_id' => $adminId
        ]);
        
        return back()->with('success', 'Post rejected. It will not be published.');
    }

    /**
     * Bulk approve or reject posts.
     */
    public function bulkAction(Request $request)
    {
        $orgId = $this->orgId();
        $adminId = session('aid');
        
        $action = $request->input('action');
        $postIds = $request->input('post_ids', []);
        
        if (empty($postIds)) {
            return response()->json(['success' => false, 'message' => 'No posts selected.']);
        }
        
        $status = $action === 'approve' ? 'approved' : 'rejected';

        CommunityPost::where('organization_id', $orgId)
            ->where('status', 'pending_stage_2')
            ->whereIn('id', $postIds)
            ->update([
                'status' => $status,
                'stage_2_admin_id' => $adminId
            ]);
            
        return response()->json([
            'success' => true, 
            'message' => count($postIds) . ' posts have been ' . $status . '.'
        ]);
    }
}
