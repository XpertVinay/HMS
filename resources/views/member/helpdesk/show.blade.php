@extends('layouts.portal')
@section('title', 'Ticket Details')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Ticket: {{ $ticket->subject }}</h2>
<div class="form-card" style="max-width: 700px;">
    <div class="form-group"><label>Category</label><p>{{ ucfirst($ticket->category) }}</p></div>
    <div class="form-group"><label>Status</label><p><span class="badge-status {{ $ticket->status }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span></p></div>
    <div class="form-group"><label>Description</label><p>{{ $ticket->description }}</p></div>
    @if($ticket->response)
    <div class="form-group"><label>Response from Admin</label><p style="background: #f0f8ff; padding: 12px; border-radius: 8px;">{{ $ticket->response }}</p></div>
    @endif
    <a href="{{ route('member.helpdesk.index') }}" class="btn-modern btn-outline">← Back</a>
</div>
@endsection
