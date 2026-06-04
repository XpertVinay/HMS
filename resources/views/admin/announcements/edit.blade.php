@extends('layouts.portal')
@section('title', 'Edit Announcement')

@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Announcement</h2>

<div class="form-card">
    <form action="{{ route('admin.announcements.update', $announcement->announcement_id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label for="announcement_subject">Subject</label>
            <input type="text" name="announcement_subject" id="announcement_subject" required value="{{ old('announcement_subject', $announcement->announcement_subject) }}">
        </div>
        <div class="form-group">
            <label for="announcement_text">Message</label>
            <textarea name="announcement_text" id="announcement_text" rows="5" required>{{ old('announcement_text', $announcement->announcement_text) }}</textarea>
        </div>
        <button type="submit" class="btn-modern">Update Announcement</button>
        <a href="{{ route('admin.announcements.index') }}" class="btn-modern btn-outline" style="margin-left: 8px;">Cancel</a>
    </form>
</div>
@endsection
