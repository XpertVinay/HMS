@extends('layouts.portal')
@section('title', 'Add Photo')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Add Photo</h2>
<div class="form-card"><form action="{{ route('admin.gallery.store') }}" method="POST">@csrf
    <div class="form-group"><label>Title</label><input type="text" name="title" required value="{{ old('title') }}"></div>
    <div class="form-group"><label>Image URL</label><input type="text" name="image_url" required value="{{ old('image_url') }}" placeholder="https://..."></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="3" required>{{ old('description') }}</textarea></div>
    <button type="submit" class="btn-modern">Add Photo</button><a href="{{ route('admin.gallery.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
