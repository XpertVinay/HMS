@extends('layouts.portal')
@section('title', 'Ticket Details')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Ticket: {{ $ticket->subject }}</h2>

<div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px;">
    <!-- Chat Area -->
    <div class="box" style="display: flex; flex-direction: column; max-height: 70vh;">
        <div style="flex: 1; overflow-y: auto; padding-right: 10px; margin-bottom: 20px; display: flex; flex-direction: column; gap: 15px;">
            <!-- Original Description -->
            <div style="align-self: flex-start; background: #f0f0f0; padding: 12px 16px; border-radius: 16px; border-bottom-left-radius: 4px; max-width: 80%;">
                <p style="margin: 0; font-size: 14px;">{{ $ticket->description }}</p>
                <small style="color: #666; font-size: 11px;">Member ({{ $ticket->member->username ?? 'N/A' }}) • {{ $ticket->created_at->format('h:i A, M d') }}</small>
            </div>

            <!-- Legacy Response (if any) -->
            @if($ticket->response)
                <div style="align-self: flex-end; background: #e3f2fd; padding: 12px 16px; border-radius: 16px; border-bottom-right-radius: 4px; max-width: 80%;">
                    <p style="margin: 0; font-size: 14px;">{{ $ticket->response }}</p>
                    <small style="color: #666; font-size: 11px;">You • Legacy Response</small>
                </div>
            @endif

            <!-- Chat Messages -->
            @foreach($ticket->messages as $msg)
                @if($msg->sender_type === 'admin')
                    <div style="align-self: flex-end; background: #e3f2fd; padding: 12px 16px; border-radius: 16px; border-bottom-right-radius: 4px; max-width: 80%;">
                        <p style="margin: 0; font-size: 14px;">{{ $msg->message }}</p>
                        <small style="color: #666; font-size: 11px;">You • {{ $msg->created_at->format('h:i A, M d') }}</small>
                    </div>
                @else
                    <div style="align-self: flex-start; background: #f0f0f0; padding: 12px 16px; border-radius: 16px; border-bottom-left-radius: 4px; max-width: 80%;">
                        <p style="margin: 0; font-size: 14px;">{{ $msg->message }}</p>
                        <small style="color: #666; font-size: 11px;">{{ ucfirst($msg->sender_type) }} • {{ $msg->created_at->format('h:i A, M d') }}</small>
                    </div>
                @endif
            @endforeach
        </div>

        <form action="{{ route('admin.helpdesk.respond', $ticket->id) }}" method="POST" style="display: flex; flex-direction: column; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
            @csrf
            <div style="display: flex; gap: 10px;">
                <input type="text" name="response" class="form-control" required placeholder="Type a message..." style="flex: 1; border-radius: 20px; padding: 10px 15px; border: 1px solid #ccc;">
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                <select name="status" class="form-control" style="width: auto; padding: 8px; border-radius: 8px;">
                    <option value="pending" {{ $ticket->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
                <button type="submit" class="btn-modern" style="border-radius: 20px; padding: 8px 16px;"><i class='bx bx-send'></i> Send & Update</button>
            </div>
        </form>
    </div>

    <!-- Ticket Sidebar Info -->
    <div class="box" style="height: fit-content;">
        <h3 style="font-size: 16px; font-weight: bold; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Details</h3>
        <p style="margin-bottom: 10px;"><strong>Member:</strong> <br> {{ $ticket->member->username ?? 'N/A' }}</p>
        <p style="margin-bottom: 10px;"><strong>Category:</strong> <br> {{ ucfirst($ticket->category) }}</p>
        <p style="margin-bottom: 10px;"><strong>Status:</strong> <br> <span class="badge-status {{ $ticket->status }}">{{ ucfirst(str_replace('_',' ',$ticket->status)) }}</span></p>
        <p style="margin-bottom: 20px;"><strong>Created:</strong> <br> {{ $ticket->created_at->format('M d, Y') }}</p>
        
        <a href="{{ route('admin.helpdesk.index') }}" class="btn-modern btn-outline" style="width: 100%; text-align: center;">← Back to Tickets</a>
    </div>
</div>
@endsection
