@extends('layouts.portal')
@section('title', 'SOLID Approvals')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">SOLID Approvals</h2>
        <p class="text-sm text-gray-500">Sale, Occupancy, Lease, Interior, Decoration (SOLID)</p>
    </div>
    <a href="{{ route('member.solid.create') }}" class="btn-modern"><i class='bx bx-plus'></i> New Request</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table ajax-table" id="solid-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Request Date</th>
                <th>Charge & Invoice</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#solid-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('member.solid.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'details', name: 'approval_type' },
                { data: 'date', name: 'created_at' },
                { data: 'fee_status', name: 'maintenance_id', orderable: false, searchable: false },
                { data: 'status', name: 'status' }
            ]
        });
    });
</script>
@endpush
