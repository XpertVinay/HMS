@extends('layouts.portal')
@section('title', 'Community Approvals (Stage 2)')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold" style="color: var(--text-primary);">Final Approvals Queue <span class="text-sm font-normal ml-2" style="color: var(--text-secondary);">(Stage 2)</span></h2>
    <div class="flex gap-2">
        <button id="bulk-approve" class="btn-modern btn-success" style="display: none;"><i class='bx bx-check-double'></i> Bulk Approve</button>
        <button id="bulk-reject" class="btn-modern btn-danger" style="display: none;"><i class='bx bx-x'></i> Bulk Reject</button>
    </div>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table" id="community-table">
            <thead>
                <tr>
                    <th class="no-sort w-10">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                    </th>
                    <th>Author</th>
                    <th>Post Content</th>
                    <th>Stage 1 Result</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    @foreach($posts as $post)
                <tr>
                    <td class="align-top">
                        <input type="checkbox" class="row-checkbox w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500" value="{{ $post->id }}">
                    </td>
                    <td class="align-top">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shrink-0">
                                {{ strtoupper(substr($post->member->username, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-sm" style="color: var(--text-primary);">{{ $post->member->username }}</h4>
                                <span class="text-xs" style="color: var(--text-secondary);">{{ $post->created_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="align-top max-w-md">
                        <h5 class="font-bold mb-1" style="color: var(--text-primary);">{{ $post->title }}</h5>
                        <p class="text-sm line-clamp-3" style="color: var(--text-secondary);">{{ $post->content }}</p>
                        @if($post->image_path)
                            <a href="{{ Storage::url($post->image_path) }}" target="_blank" class="text-[var(--primary)] text-xs mt-2 inline-block"><i class='bx bx-image'></i> View Attached Image</a>
                        @endif
                    </td>
                    <td class="align-top">
                        @if($post->stage_1_staff_id)
                            <span class="badge-status approved mb-1">Manual Approval</span>
                            <p class="text-xs mt-1" style="color: var(--text-secondary);">Approved by: {{ $post->staffReviewer->username ?? 'Staff' }}</p>
                        @elseif($post->ai_score >= 80)
                            <span class="badge-status approved mb-1">AI Auto-Approved</span>
                            <p class="text-xs mt-1" style="color: var(--text-secondary);">Score: {{ $post->ai_score }} / 100</p>
                        @endif
                    </td>
                    <td class="align-top">
                        <div class="flex gap-2">
                            <form action="{{ route('admin.community.approve', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-modern btn-success btn-sm"><i class='bx bx-check-double'></i> Final Publish</button>
                            </form>
                            <form action="{{ route('admin.community.reject', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-modern btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this post? It will not go live.')"><i class='bx bx-x'></i> Reject</button>
                            </form>
                        </div>
                    </td>
                </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle Select All
        $('#select-all').on('click', function() {
            var isChecked = $(this).prop('checked');
            $('.row-checkbox').prop('checked', isChecked);
            toggleBulkButtons();
        });

        // Handle individual row checkbox
        $('#community-table').on('change', '.row-checkbox', function() {
            if (!$(this).prop('checked')) {
                $('#select-all').prop('checked', false);
            }
            toggleBulkButtons();
        });

        function toggleBulkButtons() {
            var selectedCount = $('.row-checkbox:checked').length;
            if (selectedCount > 0) {
                $('#bulk-approve, #bulk-reject').show();
            } else {
                $('#bulk-approve, #bulk-reject').hide();
            }
        }

        // Bulk Actions
        $('#bulk-approve, #bulk-reject').on('click', function() {
            var action = $(this).attr('id') === 'bulk-approve' ? 'approve' : 'reject';
            var selectedIds = [];
            $('.row-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) return;

            if (confirm('Are you sure you want to bulk ' + action + ' ' + selectedIds.length + ' post(s)?')) {
                $.ajax({
                    url: "{{ route('admin.community.bulk') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        action: action,
                        post_ids: selectedIds
                    },
                    success: function(response) {
                        if(response.success) {
                            alert(response.message);
                            window.location.reload();
                        } else {
                            alert(response.message || 'An error occurred.');
                        }
                    },
                    error: function() {
                        alert('A server error occurred while processing your request.');
                    }
                });
            }
        });
    });
</script>
@endpush
