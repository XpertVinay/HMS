<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CommunityPost;
use App\Models\Staff;
use App\Models\Admin;
use App\Services\AIModerationService;
use App\Notifications\PostRequiresStage1Approval;
use App\Notifications\PostRequiresStage2Approval;
use Illuminate\Support\Facades\Auth;

class CommunityFeedController extends Controller
{
    /**
     * Display the feed of approved posts.
     */
    public function index()
    {
        $member = \App\Models\Member::find(session('uid'));
        $posts = CommunityPost::with('member')
            ->where('organization_id', $member->organization_id)
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('member.community.feed', compact('posts'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        return view('member.community.create');
    }

    /**
     * Store a newly created post and run AI moderation.
     */
    public function store(Request $request, AIModerationService $aiService)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $member = \App\Models\Member::find(session('uid'));

        // Handle Image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community_posts', 'public');
        }

        // Run AI Moderation
        $aiResult = $aiService->analyzeContent($request->title . ' ' . $request->content);
        
        $status = 'pending_stage_1';
        
        // If AI score is very high (e.g., > 80), auto-approve stage 1 and push to stage 2
        if ($aiResult['score'] >= 80.0) {
            $status = 'pending_stage_2';
        }

        $post = CommunityPost::create([
            'organization_id' => $member->organization_id,
            'member_id' => $member->id,
            'title' => $request->title,
            'content' => $request->content,
            'image_path' => $imagePath,
            'status' => $status,
            'ai_score' => $aiResult['score'],
            'ai_feedback' => $aiResult['feedback'],
        ]);

        // Trigger Notifications
        if ($status === 'pending_stage_1') {
            // Notify Staff
            $staffs = Staff::where('organization_id', $member->organization_id)->get();
            foreach ($staffs as $staff) {
                $staff->notify(new PostRequiresStage1Approval($post));
            }
        } elseif ($status === 'pending_stage_2') {
            // Notify Admin
            $admins = Admin::where('organization_id', $member->organization_id)->get();
            foreach ($admins as $admin) {
                $admin->notify(new PostRequiresStage2Approval($post));
            }
        }

        return redirect()->route('member.community.my_posts')->with('success', 'Post submitted successfully! It is now pending moderation.');
    }

    /**
     * Display a listing of the member's own posts and their statuses.
     */
    public function myPosts()
    {
        $member = \App\Models\Member::find(session('uid'));
        $posts = CommunityPost::where('member_id', $member->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('member.community.my_posts', compact('posts'));
    }
}
