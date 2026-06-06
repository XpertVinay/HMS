<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Announcement;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();
        $memberId = session('uid');

        $announcements = Announcement::where('organization_id', $orgId)->orderBy('created_at', 'desc')->limit(5)->get();
        $maintenances = Maintenance::where('organization_id', $orgId)->where('member_id', $memberId)->orderBy('billing_date', 'desc')->limit(5)->get();
        $unpaidCount = Maintenance::where('organization_id', $orgId)->where('member_id', $memberId)->where('status', 0)->count();
        $events = Event::where('organization_id', $orgId)->where('event_date', '>=', now())->orderBy('event_date')->limit(5)->get();

        return view('member.dashboard', compact('announcements', 'maintenances', 'unpaidCount', 'events'));
    }
}
