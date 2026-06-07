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

use Yajra\DataTables\Facades\DataTables;

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
    public function myPosts(Request $request)
    {
        $member = \App\Models\Member::find(session('uid'));

        if ($request->ajax()) {
            $query = CommunityPost::where('member_id', $member->id);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('title', function ($p) {
                    return '<span class="font-bold text-gray-800">' . $p->title . '</span>';
                })
                ->addColumn('date', function ($p) {
                    return $p->created_at ? $p->created_at->format('M d, Y') : '-';
                })
                ->addColumn('ai_score', function ($p) {
                    if ($p->ai_score) {
                        $class = $p->ai_score >= 80 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                        return '<span class="text-xs font-semibold px-2 py-1 rounded ' . $class . '">' . $p->ai_score . ' / 100</span>';
                    }
                    return '<span class="text-gray-400">N/A</span>';
                })
                ->addColumn('status', function ($p) {
                    if ($p->status === 'approved')
                        return '<span class="badge-status approved"><i class="bx bx-check"></i> Approved</span>';
                    if ($p->status === 'rejected')
                        return '<span class="badge-status rejected"><i class="bx bx-x"></i> Rejected</span>';
                    if ($p->status === 'pending_stage_1')
                        return '<span class="badge-status pending"><i class="bx bx-time"></i> Pending Stage 1 (Staff)</span>';
                    if ($p->status === 'pending_stage_2')
                        return '<span class="badge-status pending"><i class="bx bx-time"></i> Pending Stage 2 (Admin)</span>';
                    return ucfirst($p->status);
                })
                ->rawColumns(['title', 'ai_score', 'status'])
                ->make(true);
        }

        return view('member.community.my_posts');
    }
}
