<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Staff;
use App\Models\Maintenance;
use App\Models\Registry;
use App\Models\Ticket;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();

        $totalMembers = Member::where('organization_id', $orgId)->count();
        $totalStaff = Staff::where('organization_id', $orgId)->count();

        $societyFund = Maintenance::where('organization_id', $orgId)->sum('amount_payed') ?: 0;
        $unpaidMaintenance = Maintenance::where('organization_id', $orgId)->where('status', 0)->count();

        $totalRequestsResolved = Ticket::where('organization_id', $orgId)->where('status', 'resolved')->count();
        $pendingRequests = Ticket::where('organization_id', $orgId)->where('status', 'pending')->count();
        $monthlyMaintenanceCollected = Maintenance::where('organization_id', $orgId)
            ->whereYear('billing_date', Carbon::now()->year)
            ->whereMonth('billing_date', Carbon::now()->month)
            ->sum('amount_payed') ?: 0;

        $recentRegistry = Registry::where('organization_id', $orgId)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recentMembers = Member::where('organization_id', $orgId)
            ->orderBy('username', 'asc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalMembers',
            'totalStaff',
            'societyFund',
            'unpaidMaintenance',
            'recentRegistry',
            'recentMembers',
            'totalRequestsResolved',
            'pendingRequests',
            'monthlyMaintenanceCollected'
        ));
    }
}
