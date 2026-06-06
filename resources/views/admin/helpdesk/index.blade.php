@extends('layouts.portal')
@section('title', 'Helpdesk')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Helpdesk Tickets</h2>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table">
        <thead><tr><th>#</th><th>Member</th><th>Subject</th><th>Category</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
        <tbody>
            @forelse($tickets as $i => $t)
            <tr>
                <td>{{ $i+1 }}</td><td>{{ $t->member->username ?? 'N/A' }}</td><td>{{ $t->subject }}</td>
                <td>{{ ucfirst($t->category) }}</td>
                <td><span class="badge-status {{ $t->status }}">{{ ucfirst(str_replace('_',' ',$t->status)) }}</span></td>
                <td>{{ $t->created_at?->format('M d') }}</td>
                <td><a href="{{ route('admin.helpdesk.show', $t->id) }}" class="btn-modern btn-sm btn-outline">View</a></td>
            </tr>
            @empty <tr><td colspan="7">No tickets.</td></tr> @endforelse
        </tbody>
    </table>
</div></div>
@endsection
