@extends('layouts.portal')
@section('title', 'Super Admin Dashboard')
@section('content')
<div class="overview-boxes">
    <div class="box"><div class="right-side"><div class="box-topic">Total Organizations</div><div class="number">{{ $totalCount }}</div></div><i class='bx bx-building icon staff'></i></div>
    <div class="box"><div class="right-side"><div class="box-topic">Pending Approval</div><div class="number">{{ $pendingCount }}</div></div><i class='bx bx-time icon file'></i></div>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <div class="box-title">All Organizations</div>
        <table class="data-table">
            <thead><tr><th>#</th><th>Name</th><th>Subdomain</th><th>Status</th><th>Admins</th><th>Members</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($organizations as $i => $org)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td><strong>{{ $org->name }}</strong></td>
                    <td><code>{{ $org->subdomain }}</code></td>
                    <td><span class="badge-status {{ $org->status }}">{{ ucfirst($org->status) }}</span></td>
                    <td>{{ $org->admins_count }}</td>
                    <td>{{ $org->members_count }}</td>
                    <td>
                        @if($org->status === 'pending')
                        <form action="{{ route('super_admin.org.approve', $org->id) }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn-modern btn-sm btn-success">Approve</button></form>
                        <form action="{{ route('super_admin.org.reject', $org->id) }}" method="POST" style="display:inline;">@csrf<button type="submit" class="btn-modern btn-sm btn-danger">Reject</button></form>
                        @else
                        <span style="color: #888; font-size: 12px;">{{ ucfirst($org->status) }}</span>
                        @endif
                    </td>
                </tr>
                @empty <tr><td colspan="7">No organizations.</td></tr> @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
