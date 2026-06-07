@extends('layouts.portal')
@section('title', 'Admin Dashboard')

@section('content')
<div class="overview-boxes">
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Total Members</div>
            <div class="number">{{ $totalMembers }}</div>
        </div>
        <i class='bx bxs-user icon member'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Total Staff</div>
            <div class="number">{{ $totalStaff }}</div>
        </div>
        <i class='bx bxs-user-circle icon staff'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Society Fund</div>
            <div class="number">₹{{ number_format($societyFund, 2) }}</div>
        </div>
        <i class='bx bx-money icon money'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Unpaid Maintenance</div>
            <div class="number">{{ $unpaidMaintenance }}</div>
        </div>
        <i class='bx bxs-file icon file'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Amenity Bookings</div>
            <div class="number">₹0.00</div>
            <div style="font-size: 12px; color: #888;">(Coming Soon)</div>
        </div>
        <i class='bx bx-calendar-event icon' style="background: #e2e3ff; color: #4e73df;"></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Vendor Listings</div>
            <div class="number">₹0.00</div>
            <div style="font-size: 12px; color: #888;">(Coming Soon)</div>
        </div>
        <i class='bx bx-store-alt icon' style="background: #e0f8e9; color: #1cc88a;"></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Requests Resolved</div>
            <div class="number">{{ $totalRequestsResolved }}</div>
        </div>
        <i class='bx bx-check-circle icon staff'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Pending Requests</div>
            <div class="number">{{ $pendingRequests }}</div>
        </div>
        <i class='bx bx-time icon file'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Monthly Maintenance</div>
            <div class="number">₹{{ number_format($monthlyMaintenanceCollected, 2) }}</div>
        </div>
        <i class='bx bx-money icon money'></i>
    </div>
</div>

<div class="sales-boxes">
    <div class="box">
        <div class="box-title">Registry</div>
        <table class="data-table">
            <thead>
                <tr><th>#</th><th>In Time</th><th>Visitor Name</th></tr>
            </thead>
            <tbody>
                @foreach($recentRegistry as $i => $entry)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $entry->created_at?->format('M d, H:i') }}</td>
                    <td>{{ $entry->visitor_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="box">
        <div class="box-title">Members Directory</div>
        <table class="data-table">
            <thead>
                <tr><th>#</th><th>Email</th><th>Username</th></tr>
            </thead>
            <tbody>
                @foreach($recentMembers as $i => $member)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->username }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 15px;">
            <a href="{{ route('admin.members.index') }}" class="btn-modern">See All</a>
        </div>
    </div>
</div>
@endsection
