@extends('layouts.portal')
@section('title', 'Maintenance')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Maintenance Billing</h2>
    <a href="{{ route('admin.maintenance.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Create Bill</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table ajax-table" id="maintenance-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
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
        $('#maintenance-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.maintenance.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'member', name: 'member.username' },
                { data: 'billing_date', name: 'billing_date' },
                { data: 'total_amount', name: 'total_amount' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
