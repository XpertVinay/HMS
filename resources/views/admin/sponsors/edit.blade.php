@extends('layouts.portal')
@section('title', 'Edit Sponsor')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Sponsor: {{ $sponsor->name }}</h2>
<div class="form-card"><form action="{{ route('admin.sponsors.update', $sponsor->id) }}" method="POST">@csrf @method('PUT')
    <div class="form-group"><label>Name</label><input type="text" name="name" required value="{{ old('name', $sponsor->name) }}"></div>
    <div class="form-group"><label>Website URL</label><input type="url" name="website_url" value="{{ old('website_url', $sponsor->website_url) }}"></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="3" required>{{ old('description', $sponsor->description) }}</textarea></div>
    <button type="submit" class="btn-modern">Update</button><a href="{{ route('admin.sponsors.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
