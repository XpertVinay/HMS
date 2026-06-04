@extends('layouts.auth')
@section('title', 'Events')
@section('content')
<div style="max-width: 800px; width: 100%; padding: 40px 20px;">
    <h1 style="color: #fff; font-size: 28px; font-weight: 800; margin-bottom: 24px; text-align: center;">Community Events</h1>
    @forelse($events as $event)
    <div style="background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 20px; margin-bottom: 16px;">
        <h3 style="color: #fff; font-size: 18px;">{{ $event->title }}</h3>
        <p style="color: rgba(255,255,255,0.7); font-size: 13px; margin-top: 8px;">{{ $event->description }}</p>
        <span style="color: rgba(255,255,255,0.5); font-size: 12px;">{{ $event->event_date?->format('M d, Y') }}</span>
    </div>
    @empty
    <p style="color: rgba(255,255,255,0.6); text-align: center;">No events scheduled.</p>
    @endforelse
    <div class="glass-links" style="margin-top: 20px;"><a href="{{ route('home') }}">← Back to Home</a></div>
</div>
@endsection
