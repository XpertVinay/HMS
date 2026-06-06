@extends('layouts.portal')

@section('title', 'Helpdesk Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Helpdesk & Tickets</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto p-4">
        <table class="data-table ajax-table w-full" id="helpdesk-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Requester</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Details</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Vendor</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Date</th>
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
        $('#helpdesk-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('staff.helpdesk.index') }}",
            lengthMenu: [[15, 30, 50, 100], [15, 30, 50, 100]],
            pageLength: 15,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'reporter', name: 'reporter', orderable: false, searchable: false },
                { data: 'details', name: 'subject' },
                { data: 'status', name: 'status' },
                { data: 'vendor', name: 'vendor.name' },
                { data: 'date', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
