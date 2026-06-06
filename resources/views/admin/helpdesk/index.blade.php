@extends('layouts.portal')
@section('title', 'Helpdesk')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Helpdesk Tickets</h2>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table ajax-table" id="helpdesk-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Subject</th>
                <th>Category</th>
                <th>Status</th>
                <th>Date</th>
                <th class="no-sort">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div></div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#helpdesk-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.helpdesk.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'member', name: 'member.username' },
                { data: 'subject', name: 'subject' },
                { data: 'category', name: 'category', render: function(data) { return data ? data.charAt(0).toUpperCase() + data.slice(1) : ''; } },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'date', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
