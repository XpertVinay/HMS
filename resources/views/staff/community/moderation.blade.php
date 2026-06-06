@extends('layouts.portal')
@section('title', 'Community Moderation (Stage 1)')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Community Moderation Queue <span class="text-sm font-normal text-gray-500 ml-2">(Stage 1)</span></h2>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table ajax-table" id="community-table">
        <thead>
            <tr>
                <th>Author</th>
                <th>Content</th>
                <th>Date</th>
                <th class="no-sort">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#community-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('staff.community.index') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'member', name: 'member.username' },
                { data: 'content', name: 'content' },
                { data: 'date', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
