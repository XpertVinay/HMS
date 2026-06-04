@extends('layouts.portal')
@section('title', 'Gallery')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Photo Gallery</h2>
    <a href="{{ route('admin.gallery.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Photo</a>
</div>
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px;">
    @forelse($galleries as $photo)
    <div class="card" style="padding: 0; overflow: hidden;">
        <img src="{{ $photo->image_url }}" alt="{{ $photo->title }}" style="width: 100%; height: 160px; object-fit: cover;">
        <div style="padding: 12px;">
            <h3 style="font-size: 14px;">{{ $photo->title }}</h3>
            <form action="{{ route('admin.gallery.destroy', $photo->id) }}" method="POST" style="margin-top: 8px;" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn-modern btn-sm btn-danger">Delete</button></form>
        </div>
    </div>
    @empty <p style="color: #888;">No photos yet.</p> @endforelse
</div>
@endsection
