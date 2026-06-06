@extends('layouts.portal')
@section('title', 'Donors')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Donors</h2>
    <a href="{{ route('admin.donors.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Donor</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table ajax-table" id="donors-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Date</th>
                <th class="no-sort">Actions</th>
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
        $('#donors-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.donors.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'amount', name: 'amount' },
                { data: 'donation_date', name: 'donation_date' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
