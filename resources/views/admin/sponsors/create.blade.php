@extends('layouts.portal')
@section('title', 'Add Sponsor')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Add Sponsor</h2>
<div class="form-card"><form action="{{ route('admin.sponsors.store') }}" method="POST">@csrf
    <div class="form-group"><label>Name</label><input type="text" name="name" required value="{{ old('name') }}"></div>
    <div class="form-group"><label>Website URL</label><input type="url" name="website_url" value="{{ old('website_url') }}"></div>
    <div class="form-group"><label>Description</label><textarea name="description" rows="3">{{ old('description') }}</textarea></div>
    <button type="submit" class="btn-modern">Add Sponsor</button><a href="{{ route('admin.sponsors.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
