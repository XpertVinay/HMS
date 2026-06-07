@extends('layouts.portal')
@section('title', 'Super Admin Dashboard')
@section('content')
<div class="overview-boxes">
    <div class="box"><div class="right-side"><div class="box-topic">Total Organizations</div><div class="number">{{ $totalCount }}</div></div><i class='bx bx-building icon staff'></i></div>
    <div class="box"><div class="right-side"><div class="box-topic">Pending Approval</div><div class="number">{{ $pendingCount }}</div></div><i class='bx bx-time icon file'></i></div>
    <div class="box"><div class="right-side"><div class="box-topic">Today's Tickets Resolved</div><div class="number">{{ $todayTicketsResolved }}</div></div><i class='bx bx-check-circle icon' style="background: #e0f8e9; color: #1cc88a;"></i></div>
    <div class="box"><div class="right-side"><div class="box-topic">Today's Tickets Pending</div><div class="number">{{ $todayTicketsPending }}</div></div><i class='bx bx-time icon' style="background: #ffe3e3; color: #e74a3b;"></i></div>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <div class="box-title">All Organizations</div>
        <table class="data-table ajax-table" id="organizations-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Subdomain</th>
                    <th>Status</th>
                    <th>Admins</th>
                    <th>Members</th>
                    <th class="no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#organizations-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('super_admin.dashboard') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'subdomain', name: 'subdomain' },
                { data: 'status', name: 'status' },
                { data: 'admins_count', name: 'admins_count', searchable: false },
                { data: 'members_count', name: 'members_count', searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
