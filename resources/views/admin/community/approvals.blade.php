@extends('layouts.portal')
@section('title', 'Community Approvals (Stage 2)')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Final Approvals Queue <span class="text-sm font-normal text-gray-500 ml-2">(Stage 2)</span></h2>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table">
        <thead>
            <tr>
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
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shrink-0">
                            {{ strtoupper(substr($post->member->username, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">{{ $post->member->username }}</h4>
                            <span class="text-xs text-gray-500">{{ $post->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </td>
                <td class="align-top max-w-md">
                    <h5 class="font-bold text-gray-900 mb-1">{{ $post->title }}</h5>
                    <p class="text-gray-600 text-sm line-clamp-3">{{ $post->content }}</p>
                    @if($post->image_path)
                        <a href="{{ Storage::url($post->image_path) }}" target="_blank" class="text-[var(--primary)] text-xs mt-2 inline-block"><i class='bx bx-image'></i> View Attached Image</a>
                    @endif
                </td>
                <td class="align-top">
                    @if($post->stage_1_staff_id)
                        <span class="badge-status approved mb-1">Manual Approval</span>
                        <p class="text-xs text-gray-500 mt-1">Approved by: {{ $post->staffReviewer->username ?? 'Staff' }}</p>
                    @elseif($post->ai_score >= 80)
                        <span class="badge-status approved mb-1">AI Auto-Approved</span>
                        <p class="text-xs text-gray-500 mt-1">Score: {{ $post->ai_score }} / 100</p>
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

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection
