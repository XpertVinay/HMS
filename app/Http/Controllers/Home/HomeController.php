<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Donor;
use App\Models\Sponsor;
use App\Models\Member;

class HomeController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();

        $announcements = Announcement::where('organization_id', $orgId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $events = Event::where('organization_id', $orgId)
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->limit(5)
            ->get();

        $members = Member::where('organization_id', $orgId)->count();

        return view('home.index', compact('announcements', 'events', 'members'));
    }

    public function events()
    {
        $events = Event::where('organization_id', $this->orgId())
            ->orderBy('event_date', 'desc')
            ->get();

        return view('home.events', compact('events'));
    }

    public function members()
    {
        $members = Member::where('organization_id', $this->orgId())
            ->orderBy('username', 'asc')
            ->get();

        return view('home.members', compact('members'));
    }

    public function gallery()
    {
        $galleries = Gallery::where('organization_id', $this->orgId())
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return view('home.gallery', compact('galleries'));
    }

    public function donors()
    {
        $donors = Donor::where('organization_id', $this->orgId())
            ->orderBy('donation_date', 'desc')
            ->get();

        return view('home.donors', compact('donors'));
    }

    public function sponsors()
    {
        $sponsors = Sponsor::where('organization_id', $this->orgId())->get();
        return view('home.sponsors', compact('sponsors'));
    }

    public function notices()
    {
        $announcements = Announcement::where('organization_id', $this->orgId())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home.notices', compact('announcements'));
    }
}
