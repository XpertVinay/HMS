@extends('layouts.portal')
@section('title', 'Member Dashboard')
@section('content')
<div class="overview-boxes">
    <div class="box">
        <div class="right-side"><div class="box-topic">Unpaid Bills</div><div class="number">{{ $unpaidCount }}</div></div>
        <i class='bx bx-pie-chart-alt-2 icon file'></i>
    </div>
    <div class="box">
        <div class="right-side"><div class="box-topic">Total Bills</div><div class="number">{{ count($maintenances) }}</div></div>
        <i class='bx bx-money icon money'></i>
    </div>
</div>

<div class="sales-boxes">
    <div class="box">
        <div class="box-title">Recent Notices</div>
        @forelse($announcements as $notice)
            <div style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;">
                <strong>{{ $notice->announcement_subject }}</strong>
                <p style="font-size: 13px; color: #666; margin-top: 4px;">{{ Str::limit($notice->announcement_text, 100) }}</p>
            </div>
        @empty
            <p style="color: #888;">No notices.</p>
        @endforelse
    </div>

    <div class="box">
        <div class="box-title">Upcoming Events</div>
        @forelse($events as $event)
            <div style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;">
                <strong>{{ $event->title }}</strong>
                <p style="font-size: 12px; color: #999;">{{ $event->event_date?->format('M d, Y') }}</p>
            </div>
        @empty
            <p style="color: #888;">No upcoming events.</p>
        @endforelse
    </div>
</div>
@endsection
