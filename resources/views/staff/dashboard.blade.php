@extends('layouts.portal')
@section('title', 'Staff Dashboard')
@section('content')
<div class="overview-boxes">
    <div class="box"><div class="right-side"><div class="box-topic">Total Members</div><div class="number">{{ $totalMembers }}</div></div><i class='bx bxs-user icon member'></i></div>
</div>
<div class="sales-boxes">
    <div class="box">
        <div class="box-title">Recent Notices</div>
        @forelse($announcements as $notice)
        <div style="padding: 10px 0; border-bottom: 1px solid #f0f0f0;"><strong>{{ $notice->announcement_subject }}</strong><p style="font-size: 13px; color: #666;">{{ Str::limit($notice->announcement_text, 100) }}</p></div>
        @empty <p style="color: #888;">No notices.</p> @endforelse
    </div>
    <div class="box">
        <div class="box-title">Recent Visitors</div>
        <table class="data-table"><thead><tr><th>#</th><th>Time</th><th>Visitor</th></tr></thead><tbody>
            @forelse($recentRegistry as $i => $e)<tr><td>{{ $i+1 }}</td><td>{{ $e->created_at?->format('M d, H:i') }}</td><td>{{ $e->visitor_name }}</td></tr>
            @empty <tr><td colspan="3">No entries.</td></tr> @endforelse
        </tbody></table>
    </div>
</div>
@endsection
