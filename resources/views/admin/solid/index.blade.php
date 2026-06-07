@extends('layouts.portal')
@section('title', 'SOLID Approvals (Stage 2)')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold" style="color: var(--text-primary);">SOLID Approvals Queue <span class="text-sm font-normal ml-2" style="color: var(--text-secondary);">(Stage 2 / Final)</span></h2>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
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
