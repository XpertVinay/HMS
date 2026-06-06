@extends('layouts.portal')
@section('title', 'Properties')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Properties</h2>
    <a href="{{ route('admin.properties.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Property</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table ajax-table" id="properties-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Address</th>
                <th>Type</th>
                <th>Owner</th>
                <th>Resident</th>
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
        $('#properties-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.properties.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'address', name: 'address' },
                { data: 'type', name: 'type' },
                { data: 'owner_name', name: 'owner.username' },
                { data: 'resident_name', name: 'resident.username' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
