@extends('layouts.portal')
@section('title', 'My Community Posts')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">My Community Posts</h2>
    <a href="{{ route('member.community.feed') }}" class="btn-modern btn-outline">Back to Feed</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Submitted On</th>
                <th>AI Score</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>
                    <span class="font-bold text-gray-800">{{ $post->title }}</span>
                </td>
                <td>{{ $post->created_at->format('M d, Y') }}</td>
                <td>
                    @if($post->ai_score)
                        <span class="text-xs font-semibold px-2 py-1 rounded {{ $post->ai_score >= 80 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $post->ai_score }} / 100
                        </span>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </td>
                <td>
                    @if($post->status === 'approved')
                        <span class="badge-status approved"><i class='bx bx-check'></i> Approved</span>
                    @elseif($post->status === 'rejected')
                        <span class="badge-status rejected"><i class='bx bx-x'></i> Rejected</span>
                    @elseif($post->status === 'pending_stage_1')
                        <span class="badge-status pending"><i class='bx bx-time'></i> Pending Stage 1 (Staff)</span>
                    @elseif($post->status === 'pending_stage_2')
                        <span class="badge-status pending"><i class='bx bx-time'></i> Pending Stage 2 (Admin)</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-8 text-gray-500">You haven't submitted any posts yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection
