@extends('layouts.portal')
@section('title', 'Notices')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Announcements</h2>
    <a href="{{ route('admin.announcements.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add New</a>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table">
            <thead>
                <tr><th>#</th><th>Subject</th><th>Message</th><th>Date</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($announcements as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $item->announcement_subject }}</strong></td>
                    <td>{{ Str::limit($item->announcement_text, 80) }}</td>
                    <td>{{ $item->created_at?->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.announcements.edit', $item->announcement_id) }}" class="btn-modern btn-sm btn-outline">Edit</a>
                        <form action="{{ route('admin.announcements.destroy', $item->announcement_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this announcement?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-modern btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5">No announcements found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
