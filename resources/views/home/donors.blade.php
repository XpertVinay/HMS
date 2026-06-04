@extends('layouts.auth')
@section('title', 'Donors')
@section('content')
<div style="max-width: 700px; width: 100%; padding: 40px 20px;">
    <h1 style="color: #fff; font-size: 28px; font-weight: 800; margin-bottom: 24px; text-align: center;">Our Donors</h1>
    @forelse($donors as $donor)
    <div style="background: rgba(255,255,255,0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 16px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center;">
        <div><span style="color: #fff; font-weight: 600;">{{ $donor->name }}</span><br><span style="color: rgba(255,255,255,0.5); font-size: 12px;">{{ $donor->donation_date?->format('M d, Y') }}</span></div>
        <span style="color: #6bffb0; font-weight: 700; font-size: 18px;">₹{{ number_format($donor->amount, 2) }}</span>
    </div>
    @empty
    <p style="color: rgba(255,255,255,0.6); text-align: center;">No donors yet.</p>
    @endforelse
    <div class="glass-links" style="margin-top: 20px;"><a href="{{ route('home') }}">← Back to Home</a></div>
</div>
@endsection
