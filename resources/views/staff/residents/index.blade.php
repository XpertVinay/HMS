@extends('layouts.portal')

@section('title', 'Residents Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Residents (Tenants)</h2>
    <div class="flex gap-3">
        <a href="{{ route('staff.residents.create') }}" class="btn-modern">
            <i class='bx bx-user-plus'></i> Add Resident
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto p-4">
        <table class="data-table ajax-table w-full" id="residents-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Username</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Email</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Phone</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Verification</th>
                    <th class="p-4 text-sm font-semibold text-gray-600 no-sort">Action</th>
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
        $('#residents-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('staff.residents.index') }}",
            lengthMenu: [[15, 30, 50, 100], [15, 30, 50, 100]],
            pageLength: 15,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'username', name: 'username', render: function(data) { return '<span class="block text-sm font-bold text-gray-800">' + data + '</span>'; } },
                { data: 'email', name: 'email', render: function(data) { return data ? data : 'N/A'; } },
                { data: 'mobile_number', name: 'mobile_number', render: function(data) { return data ? data : 'N/A'; } },
                { data: 'is_rent_agreement_verified_staff', name: 'is_rent_agreement_verified_staff', render: function(data) { 
                    return data ? '<span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800">Verified by Staff</span>' : '<span class="px-2 py-1 rounded text-xs font-bold bg-yellow-100 text-yellow-800">Pending Verification</span>'; 
                } },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
