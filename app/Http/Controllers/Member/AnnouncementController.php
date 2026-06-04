<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('organization_id', $this->orgId())->orderBy('created_at', 'desc')->get();
        return view('member.announcements.index', compact('announcements'));
    }
}
