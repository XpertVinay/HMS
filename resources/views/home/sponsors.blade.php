@extends('layouts.auth')
@section('title', 'Sponsors')
@section('content')
<div style="max-width: 700px; width: 100%; padding: 40px 20px;">
    <h1 style="color: #fff; font-size: 28px; font-weight: 800; margin-bottom: 24px; text-align: center;">Our Sponsors</h1>
    @forelse($sponsors as $sponsor)
    <div style="background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 16px; margin-bottom: 12px;">
        <h3 style="color: #fff; font-size: 16px;">{{ $sponsor->name }}</h3>
        @if($sponsor->description)<p style="color: rgba(255,255,255,0.7); font-size: 13px; margin-top: 6px;">{{ $sponsor->description }}</p>@endif
        @if($sponsor->website_url)<a href="{{ $sponsor->website_url }}" target="_blank" style="color: #a0b4ff; font-size: 12px;">{{ $sponsor->website_url }}</a>@endif
    </div>
    @empty
    <p style="color: rgba(255,255,255,0.6); text-align: center;">No sponsors yet.</p>
    @endforelse
    <div class="glass-links" style="margin-top: 20px;"><a href="{{ route('home') }}">← Back to Home</a></div>
</div>
@endsection
