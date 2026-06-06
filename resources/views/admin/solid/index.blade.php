@extends('layouts.portal')
@section('title', 'SOLID Approvals (Stage 2)')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">SOLID Approvals Queue <span class="text-sm font-normal text-gray-500 ml-2">(Stage 2 / Final)</span></h2>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table ajax-table w-full" id="solid-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Request Details</th>
                <th>Stage 1 Result</th>
                <th class="no-sort">Action</th>
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
            ajax: "{{ route('admin.solid.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'member', name: 'member.username' },
                { data: 'details', name: 'description', orderable: false },
                { data: 'stage_1', name: 'stage_1', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
