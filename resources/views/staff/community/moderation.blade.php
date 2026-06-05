@extends('layouts.portal')
@section('title', 'Community Moderation (Stage 1)')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Community Moderation Queue <span class="text-sm font-normal text-gray-500 ml-2">(Stage 1)</span></h2>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table">
        <thead>
            <tr>
                <th>Author</th>
                <th>Post Content</th>
                <th>AI Moderation</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
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
                    @if($post->ai_score)
                        <div class="mb-1">
                            <span class="text-xs font-semibold px-2 py-1 rounded {{ $post->ai_score >= 80 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                Score: {{ $post->ai_score }} / 100
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 italic mt-2">{{ $post->ai_feedback }}</p>
                    @else
                        <span class="text-gray-400">Not Scored</span>
                    @endif
                </td>
                <td class="align-top">
                    <div class="flex gap-2">
                        <form action="{{ route('staff.community.approve', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-modern btn-success btn-sm"><i class='bx bx-check'></i> Approve</button>
                        </form>
                        <form action="{{ route('staff.community.reject', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-modern btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this post?')"><i class='bx bx-x'></i> Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-12 text-gray-500">
                    <i class='bx bx-check-shield text-5xl text-gray-300 mb-3 block'></i>
                    No posts require Stage 1 moderation at this time.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection
