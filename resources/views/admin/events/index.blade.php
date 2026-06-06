@extends('layouts.portal')
@section('title', 'Events')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Events</h2>
    <a href="{{ route('admin.events.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Event</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table"><thead><tr><th>#</th><th>Title</th><th>Date</th><th>Actions</th></tr></thead><tbody>
    @forelse($events as $i => $e)<tr><td>{{ $i+1 }}</td><td>{{ $e->title }}</td><td>{{ $e->event_date?->format('M d, Y') }}</td><td><a href="{{ route('admin.events.edit', $e->id) }}" class="btn-modern btn-sm btn-outline">Edit</a> <form action="{{ route('admin.events.destroy', $e->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn-modern btn-sm btn-danger">Delete</button></form></td></tr>
    @empty <tr><td colspan="4">No events.</td></tr> @endforelse
    </tbody></table>
</div></div>
@endsection
