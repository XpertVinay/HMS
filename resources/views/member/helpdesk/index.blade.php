@extends('layouts.portal')
@section('title', 'Helpdesk')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">My Tickets</h2>
    <a href="{{ route('member.helpdesk.create') }}" class="btn-modern"><i class='bx bx-plus'></i> New Ticket</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table">
        <thead><tr><th>#</th><th>Subject</th><th>Category</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @forelse($tickets as $i => $t)
            <tr>
                <td>{{ $i+1 }}</td><td>{{ $t->subject }}</td><td>{{ $t->category }}</td>
                <td><span class="badge-status {{ $t->status }}">{{ ucfirst(str_replace('_',' ',$t->status)) }}</span></td>
                <td>{{ $t->created_at?->format('M d, Y') }}</td>
            </tr>
            @empty <tr><td colspan="5">No tickets yet.</td></tr> @endforelse
        </tbody>
    </table>
</div></div>
@endsection
