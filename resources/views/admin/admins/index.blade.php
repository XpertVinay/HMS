@extends('layouts.portal')
@section('title', 'Admins Management')
@section('content')
<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div class="box-title">Admins</div>
            <a href="{{ route('admin.admins.create') }}" class="btn-modern btn-primary">Add Admin</a>
        </div>
        <table class="data-table ajax-table" id="admins-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
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
        $('#admins-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.admins.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'username', name: 'username', render: function(data) { return '<strong>'+data+'</strong>'; } },
                { data: 'email', name: 'email' },
                { data: 'mobile_number', name: 'mobile_number', render: function(data) { return data ? data : 'N/A'; } },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
