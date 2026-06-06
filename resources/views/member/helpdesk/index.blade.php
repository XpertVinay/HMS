@extends('layouts.portal')
@section('title', 'Helpdesk')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">My Tickets</h2>
    <a href="{{ route('member.helpdesk.create') }}" class="btn-modern"><i class='bx bx-plus'></i> New Ticket</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table ajax-table" id="helpdesk-table" style="width: 100%">
        <thead><tr><th>#</th><th>Subject</th><th>Category</th><th>Status</th><th>Date</th><th class="no-sort">Action</th></tr></thead>
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
            ajax: "{{ route('member.helpdesk.index') }}",
            lengthMenu: [[15, 30, 50, 100], [15, 30, 50, 100]],
            pageLength: 15,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
                { data: 'subject', name: 'subject' },
                { data: 'category', name: 'category' },
                { data: 'status', name: 'status' },
                { data: 'date', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
