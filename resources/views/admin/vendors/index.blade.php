@extends('layouts.portal')
@section('title', 'Vendors')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Vendors</h2>
    <a href="{{ route('admin.vendors.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Vendor</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table ajax-table" id="vendors-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Business</th>
                <th>Email</th>
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
        $('#vendors-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.vendors.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'business_name', name: 'business_name' },
                { data: 'email', name: 'email' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
