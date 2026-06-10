@extends('layouts.portal')
@section('title', 'Add Event')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Create Event</h2>
<div class="form-card"><form action="{{ route('admin.events.store') }}" method="POST">@csrf
    <div class="form-group"><label>Title</label><input type="text" name="title" required value="{{ old('title') }}"></div>
    <div class="form-group"><label>Date</label><input type="date" name="event_date" required value="{{ old('event_date') }}"></div>
    <div class="form-group"><label>Time</label><input type="time" name="event_time" value="{{ old('event_time') }}" required></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="4" required>{{ old('description') }}</textarea></div>
    <button type="submit" class="btn-modern">Create Event</button><a href="{{ route('admin.events.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
