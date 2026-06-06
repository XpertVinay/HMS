@extends('layouts.portal')
@section('title', 'My Community Posts')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">My Community Posts</h2>
    <a href="{{ route('member.community.feed') }}" class="btn-modern btn-outline">Back to Feed</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table ajax-table" id="myposts-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Submitted On</th>
                <th>AI Score</th>
                <th>Status</th>
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
        $('#myposts-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('member.community.my_posts') }}",
            lengthMenu: [[10, 20, 30, 40, 50], [10, 20, 30, 40, 50]],
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Search records..."
            },
            columns: [
                { data: 'title', name: 'title' },
                { data: 'date', name: 'created_at' },
                { data: 'ai_score', name: 'ai_score' },
                { data: 'status', name: 'status' }
            ]
        });
    });
</script>
@endpush
