@extends('layouts.portal')
@section('title', 'My Maintenance')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">My Maintenance Bills</h2>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table ajax-table" id="maintenance-table" style="width: 100%">
        <thead><tr><th>#</th><th>Billing Month</th><th>Total</th><th>Due Date</th><th>Status</th><th class="no-sort">Action</th></tr></thead>
        <tbody>
        </tbody>
    </table>
</div></div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#maintenance-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('member.maintenance.index') }}",
            lengthMenu: [[15, 30, 50, 100], [15, 30, 50, 100]],
            pageLength: 15,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'id', orderable: false, searchable: false },
                { data: 'month', name: 'billing_date' },
                { data: 'amount', name: 'total_amount' },
                { data: 'due_date', name: 'due_date' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
