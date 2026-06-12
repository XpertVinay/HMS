<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Staff;
use App\Models\Maintenance;
use App\Models\Registry;
use App\Models\Ticket;
use App\Models\Property;
use App\Models\Resident;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();
        
        $org = Organization::with('industry')->find($orgId);
        $industrySlug = $org && $org->industry ? Str::slug($org->industry->name) : 'rwa-resident-welfare-association';

        $widgets = [];
        $tables = [];

        // Generic common data
        $totalMembers = Member::where('organization_id', $orgId)->count();
        $totalStaff = Staff::where('organization_id', $orgId)->count();
        $totalRequestsResolved = Ticket::where('organization_id', $orgId)->where('status', 'resolved')->count();
        $pendingRequests = Ticket::where('organization_id', $orgId)->where('status', 'pending')->count();
        
        $recentMembers = Member::where('organization_id', $orgId)
            ->orderBy('username', 'asc')
            ->limit(10)
            ->get();

        if ($industrySlug === 'healthcare') {
            $widgets = [
                ['title' => 'Total Patients', 'value' => $totalMembers, 'icon' => 'bxs-user', 'color_class' => 'member'],
                ['title' => 'Clinical Staff', 'value' => $totalStaff, 'icon' => 'bxs-user-circle', 'color_class' => 'staff'],
                ['title' => 'Resolved Cases', 'value' => $totalRequestsResolved, 'icon' => 'bx-check-circle', 'color_class' => 'staff'],
                ['title' => 'Pending Appointments', 'value' => $pendingRequests, 'icon' => 'bx-time', 'color_class' => 'file'],
            ];

            $tables = [
                [
                    'title' => 'Recent Patients',
                    'columns' => ['#', 'Email', 'Username'],
                    'data' => $recentMembers->map(fn($m, $i) => [$i + 1, $m->email, $m->username]),
                    'action_url' => route('admin.members.index')
                ]
            ];
        } 
        elseif ($industrySlug === 'education') {
            $widgets = [
                ['title' => 'Total Students', 'value' => $totalMembers, 'icon' => 'bxs-user', 'color_class' => 'member'],
                ['title' => 'Teaching Staff', 'value' => $totalStaff, 'icon' => 'bxs-user-circle', 'color_class' => 'staff'],
                ['title' => 'Resolved Queries', 'value' => $totalRequestsResolved, 'icon' => 'bx-check-circle', 'color_class' => 'staff'],
                ['title' => 'Pending Queries', 'value' => $pendingRequests, 'icon' => 'bx-time', 'color_class' => 'file'],
            ];

            $tables = [
                [
                    'title' => 'Recent Students',
                    'columns' => ['#', 'Email', 'Username'],
                    'data' => $recentMembers->map(fn($m, $i) => [$i + 1, $m->email, $m->username]),
                    'action_url' => route('admin.members.index')
                ]
            ];
        }
        elseif ($industrySlug === 'real-estate') {
            $totalProperties = Property::where('organization_id', $orgId)->count();
            $totalTenants = Resident::where('organization_id', $orgId)->count();

            $widgets = [
                ['title' => 'Total Properties', 'value' => $totalProperties, 'icon' => 'bx-building-house', 'color_class' => 'member'],
                ['title' => 'Active Tenants', 'value' => $totalTenants, 'icon' => 'bx-home-smile', 'color_class' => 'staff'],
                ['title' => 'Staff Members', 'value' => $totalStaff, 'icon' => 'bxs-user-circle', 'color_class' => 'staff'],
                ['title' => 'Pending Maintenance', 'value' => $pendingRequests, 'icon' => 'bx-time', 'color_class' => 'file'],
            ];

            $tables = [
                [
                    'title' => 'Recent Tenants',
                    'columns' => ['#', 'Email', 'Username'],
                    'data' => $recentMembers->map(fn($m, $i) => [$i + 1, $m->email, $m->username]),
                    'action_url' => route('admin.members.index')
                ]
            ];
        }
        else {
            // Default (RWA)
            $societyFund = Maintenance::where('organization_id', $orgId)->sum('amount_payed') ?: 0;
            $unpaidMaintenance = Maintenance::where('organization_id', $orgId)->where('status', 0)->count();
            $monthlyMaintenanceCollected = Maintenance::where('organization_id', $orgId)
                ->whereYear('billing_date', Carbon::now()->year)
                ->whereMonth('billing_date', Carbon::now()->month)
                ->sum('amount_payed') ?: 0;
            $recentRegistry = Registry::where('organization_id', $orgId)
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $widgets = [
                ['title' => 'Total Members', 'value' => $totalMembers, 'icon' => 'bxs-user', 'color_class' => 'member'],
                ['title' => 'Total Staff', 'value' => $totalStaff, 'icon' => 'bxs-user-circle', 'color_class' => 'staff'],
                ['title' => 'Society Fund', 'value' => '₹' . number_format($societyFund, 2), 'icon' => 'bx-money', 'color_class' => 'money'],
                ['title' => 'Unpaid Maintenance', 'value' => $unpaidMaintenance, 'icon' => 'bxs-file', 'color_class' => 'file'],
                ['title' => 'Amenity Bookings', 'value' => '₹0.00', 'subtitle' => '(Coming Soon)', 'icon' => 'bx-calendar-event', 'color_class' => 'icon', 'style' => 'background: #e2e3ff; color: #4e73df;'],
                ['title' => 'Vendor Listings', 'value' => '₹0.00', 'subtitle' => '(Coming Soon)', 'icon' => 'bx-store-alt', 'color_class' => 'icon', 'style' => 'background: #e0f8e9; color: #1cc88a;'],
                ['title' => 'Requests Resolved', 'value' => $totalRequestsResolved, 'icon' => 'bx-check-circle', 'color_class' => 'staff'],
                ['title' => 'Pending Requests', 'value' => $pendingRequests, 'icon' => 'bx-time', 'color_class' => 'file'],
                ['title' => 'Monthly Maintenance', 'value' => '₹' . number_format($monthlyMaintenanceCollected, 2), 'icon' => 'bx-money', 'color_class' => 'money'],
            ];

            $tables = [
                [
                    'title' => 'Registry',
                    'columns' => ['#', 'In Time', 'Visitor Name'],
                    'data' => $recentRegistry->map(fn($r, $i) => [$i + 1, $r->created_at?->format('M d, H:i'), $r->visitor_name]),
                    'action_url' => null
                ],
                [
                    'title' => 'Members Directory',
                    'columns' => ['#', 'Email', 'Username'],
                    'data' => $recentMembers->map(fn($m, $i) => [$i + 1, $m->email, $m->username]),
                    'action_url' => route('admin.members.index')
                ]
            ];
        }

        return view('admin.dashboard', compact('widgets', 'tables'));
    }
}
