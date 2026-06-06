@extends('layouts.portal')
@section('title', 'Notices')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Announcements</h2>
    <a href="{{ route('admin.announcements.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add New</a>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table ajax-table" id="announcements-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
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
        $('#announcements-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.announcements.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'announcement_subject', name: 'announcement_subject', render: function(data) { return '<strong>'+data+'</strong>'; } },
                { data: 'announcement_text', name: 'announcement_text', render: function(data, type, row) { return data ? data.substring(0, 80) + (data.length > 80 ? '...' : '') : ''; } },
                { data: 'date', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
