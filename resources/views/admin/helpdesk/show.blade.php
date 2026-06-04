@extends('layouts.portal')
@section('title', 'Ticket Details')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Ticket: {{ $ticket->subject }}</h2>
<div class="form-card" style="max-width: 700px;">
    <div class="form-group"><label>Member</label><p>{{ $ticket->member->username ?? 'N/A' }}</p></div>
    <div class="form-group"><label>Category</label><p>{{ ucfirst($ticket->category) }}</p></div>
    <div class="form-group"><label>Status</label><p><span class="badge-status {{ $ticket->status }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span></p></div>
    <div class="form-group"><label>Description</label><p>{{ $ticket->description }}</p></div>

    <form action="{{ route('admin.helpdesk.respond', $ticket->id) }}" method="POST" style="margin-top: 20px; border-top: 2px solid #f0f0f0; padding-top: 20px;">
        @csrf
        <div class="form-group"><label>Response</label><textarea name="response" rows="4" required>{{ old('response', $ticket->response) }}</textarea></div>
        <div class="form-group"><label>Update Status</label>
            <select name="status" required>
                <option value="pending" {{ $ticket->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
        <button type="submit" class="btn-modern">Submit Response</button>
    </form>
    <a href="{{ route('admin.helpdesk.index') }}" class="btn-modern btn-outline" style="margin-top: 12px;">← Back</a>
</div>
@endsection
