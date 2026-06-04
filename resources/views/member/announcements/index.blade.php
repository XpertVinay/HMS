@extends('layouts.portal')
@section('title', 'Notices')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Notices</h2>
<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        @forelse($announcements as $notice)
        <div style="padding: 14px 0; border-bottom: 1px solid #f0f0f0;">
            <h3 style="font-size: 15px; font-weight: 600;">{{ $notice->announcement_subject }}</h3>
            <p style="font-size: 13px; color: #666; margin-top: 6px;">{{ $notice->announcement_text }}</p>
            <span style="font-size: 12px; color: #999;">{{ $notice->created_at?->format('M d, Y') }}</span>
        </div>
        @empty
        <p style="color: #888;">No announcements yet.</p>
        @endforelse
    </div>
</div>
@endsection
