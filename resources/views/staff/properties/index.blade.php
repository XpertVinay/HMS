@extends('layouts.portal')

@section('title', 'Properties Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Properties & Units</h2>
    <div class="flex gap-3">
        <a href="{{ route('staff.properties.bulk_upload') }}" class="btn-modern btn-outline">
            <i class='bx bx-upload'></i> Bulk Upload
        </a>
        <a href="{{ route('staff.properties.create') }}" class="btn-modern">
            <i class='bx bx-plus'></i> Add Property
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto p-4">
        <table class="data-table ajax-table w-full" id="properties-table">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Property No</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Type</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Owner</th>
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
        $('#properties-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('staff.properties.index') }}",
            lengthMenu: [[15, 30, 50, 100], [15, 30, 50, 100]],
            pageLength: 15,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'property_info', name: 'property_number' },
                { data: 'type', name: 'type' },
                { data: 'owner', name: 'owner.name' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
