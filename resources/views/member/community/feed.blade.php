@extends('layouts.portal')
@section('title', 'Community Feed')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Community Feed</h2>
    <div class="flex gap-2">
        <a href="{{ route('member.community.my_posts') }}" class="btn-modern btn-outline">My Posts</a>
        <a href="{{ route('member.community.create') }}" class="btn-modern"><i class='bx bx-plus'></i> New Post</a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($posts as $post)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300">
            @if($post->image_path)
                <img src="{{ Storage::url($post->image_path) }}" class="w-full h-48 object-cover" alt="Post Image">
            @endif
            <div class="p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-purple-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($post->member->username, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900">{{ $post->member->username }}</h4>
                        <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $post->title }}</h3>
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($post->content, 150) }}</p>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 border-dashed">
            <i class='bx bx-news text-5xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">No posts in the community feed yet.</p>
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $posts->links() }}
</div>
@endsection
