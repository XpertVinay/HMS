@extends('layouts.auth')
@section('title', 'Gallery')
@section('content')
<div style="max-width: 900px; width: 100%; padding: 40px 20px;">
    <h1 style="color: #fff; font-size: 28px; font-weight: 800; margin-bottom: 24px; text-align: center;">Photo Gallery</h1>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
        @forelse($galleries as $photo)
        <div style="border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.15);">
            <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" style="width: 100%; height: 160px; object-fit: cover;">
            <div style="padding: 10px; background: rgba(255,255,255,0.05);"><span style="color: #fff; font-size: 13px;">{{ $photo->title }}</span></div>
        </div>
        @empty
        <p style="color: rgba(255,255,255,0.6); text-align: center; grid-column: 1/-1;">No photos yet.</p>
        @endforelse
    </div>
    <div class="glass-links" style="margin-top: 20px;"><a href="{{ route('home') }}">← Back to Home</a></div>
</div>
@endsection
