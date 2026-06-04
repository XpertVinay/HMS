@extends('layouts.auth')
@section('title', 'Notices')
@section('content')
<div style="max-width: 700px; width: 100%; padding: 40px 20px;">
    <h1 style="color: #fff; font-size: 28px; font-weight: 800; margin-bottom: 24px; text-align: center;">Notices</h1>
    @forelse($announcements as $notice)
    <div style="background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 16px; margin-bottom: 12px;">
        <h3 style="color: #fff; font-size: 16px;">{{ $notice->announcement_subject }}</h3>
        <p style="color: rgba(255,255,255,0.7); font-size: 13px; margin-top: 6px;">{{ $notice->announcement_text }}</p>
        <span style="color: rgba(255,255,255,0.4); font-size: 12px;">{{ $notice->created_at?->format('M d, Y') }}</span>
    </div>
    @empty
    <p style="color: rgba(255,255,255,0.6); text-align: center;">No notices yet.</p>
    @endforelse
    <div class="glass-links" style="margin-top: 20px;"><a href="{{ route('home') }}">← Back to Home</a></div>
</div>
@endsection
