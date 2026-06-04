@extends('layouts.portal')
@section('title', 'Sponsors')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Sponsors</h2>
    <a href="{{ route('admin.sponsors.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Sponsor</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table"><thead><tr><th>#</th><th>Name</th><th>Website</th><th>Actions</th></tr></thead><tbody>
    @forelse($sponsors as $i => $s)<tr><td>{{ $i+1 }}</td><td>{{ $s->name }}</td><td>{{ $s->website_url }}</td><td><a href="{{ route('admin.sponsors.edit', $s->id) }}" class="btn-modern btn-sm btn-outline">Edit</a> <form action="{{ route('admin.sponsors.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn-modern btn-sm btn-danger">Delete</button></form></td></tr>
    @empty <tr><td colspan="4">No sponsors.</td></tr> @endforelse
    </tbody></table>
</div></div>
@endsection
