@extends('layouts.portal')
@section('title', 'New Ticket')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Create Support Ticket</h2>
<div class="form-card">
    <form action="{{ route('member.helpdesk.store') }}" method="POST">
        @csrf
        <div class="form-group"><label>Subject</label><input type="text" name="subject" required value="{{ old('subject') }}"></div>
        <div class="form-group"><label>Category</label>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="maintenance">Maintenance</option>
                <option value="security">Security</option>
                <option value="parking">Parking</option>
                <option value="noise">Noise Complaint</option>
                <option value="general">General</option>
            </select>
        </div>
        <div class="form-group"><label>Description</label><textarea name="description" rows="5" required>{{ old('description') }}</textarea></div>
        <button type="submit" class="btn-modern">Submit Ticket</button>
        <a href="{{ route('member.helpdesk.index') }}" class="btn-modern btn-outline" style="margin-left: 8px;">Cancel</a>
    </form>
</div>
@endsection
