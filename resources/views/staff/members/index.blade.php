@extends('layouts.portal')

@section('title', 'Members Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Members (Owners)</h2>
    <div class="flex gap-3">
        <a href="{{ route('staff.members.create') }}" class="btn-modern">
            <i class='bx bx-user-plus'></i> Add Member
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto p-4">
        <table class="data-table ajax-table w-full" id="members-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Name</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Username</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Email</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Phone</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
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
        $('#members-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('staff.members.index') }}",
            lengthMenu: [[15, 30, 50, 100], [15, 30, 50, 100]],
            pageLength: 15,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name', render: function(data, type, row) { 
                    return '<div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs uppercase">' + (data ? data.substring(0,2) : 'NA') + '</div><span class="block text-sm font-bold text-gray-800">' + data + '</span></div>'; 
                } },
                { data: 'username', name: 'username' },
                { data: 'email', name: 'email', render: function(data) { return data ? data : 'N/A'; } },
                { data: 'phone', name: 'phone', render: function(data) { return data ? data : 'N/A'; } },
                { data: 'is_approved', name: 'is_approved', render: function(data) { 
                    return data ? '<span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800">Approved</span>' : '<span class="px-2 py-1 rounded text-xs font-bold bg-yellow-100 text-yellow-800">Pending</span>'; 
                } },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
