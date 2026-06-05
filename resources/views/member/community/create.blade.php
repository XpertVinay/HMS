@extends('layouts.portal')
@section('title', 'Create Community Post')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Create Community Post</h2>
    <a href="{{ route('member.community.feed') }}" class="btn-modern btn-outline">Back to Feed</a>
</div>

<div class="form-card">
    <p class="text-sm text-gray-500 mb-6 pb-4 border-b border-gray-100">
        <i class='bx bx-info-circle text-[var(--primary)]'></i> All posts are subject to a 2-stage verification process to ensure a safe community environment.
    </p>

    <form action="{{ route('member.community.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" required placeholder="What's your post about?" value="{{ old('title') }}">
        </div>
        
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" rows="6" required placeholder="Write your community update here...">{{ old('content') }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Image (Optional)</label>
            <input type="file" name="image" accept="image/*">
        </div>
        
        <div class="mt-6">
            <button type="submit" class="btn-modern w-full"><i class='bx bx-send'></i> Submit for Moderation</button>
        </div>
    </form>
</div>
@endsection
