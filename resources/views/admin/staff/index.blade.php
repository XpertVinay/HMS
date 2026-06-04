@extends('layouts.portal')
@section('title', 'Staff')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Staff</h2>
    <a href="{{ route('admin.staff.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Staff</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table"><thead><tr><th>#</th><th>Username</th><th>Email</th><th>Actions</th></tr></thead><tbody>
    @forelse($staff as $i => $s)<tr><td>{{ $i+1 }}</td><td>{{ $s->username }}</td><td>{{ $s->email }}</td><td><a href="{{ route('admin.staff.edit', $s->id) }}" class="btn-modern btn-sm btn-outline">Edit</a> <form action="{{ route('admin.staff.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn-modern btn-sm btn-danger">Delete</button></form></td></tr>
    @empty <tr><td colspan="4">No staff found.</td></tr> @endforelse
    </tbody></table>
</div></div>
@endsection
