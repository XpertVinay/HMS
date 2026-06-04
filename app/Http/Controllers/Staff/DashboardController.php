<?php
namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Registry;
use App\Models\Announcement;

class DashboardController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();
        $totalMembers = Member::where('organization_id', $orgId)->count();
        $recentRegistry = Registry::where('organization_id', $orgId)->orderBy('created_at', 'desc')->limit(10)->get();
        $announcements = Announcement::where('organization_id', $orgId)->orderBy('created_at', 'desc')->limit(5)->get();

        return view('staff.dashboard', compact('totalMembers', 'recentRegistry', 'announcements'));
    }
}
