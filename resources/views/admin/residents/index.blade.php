@extends('layouts.portal')
@section('title', 'Residents')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Residents</h2>
    <a href="{{ route('admin.residents.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Resident</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table"><thead><tr><th>#</th><th>Username</th><th>Email</th><th>Address</th><th>Actions</th></tr></thead><tbody>
    @forelse($residents as $i => $r)<tr><td>{{ $i+1 }}</td><td>{{ $r->username }}</td><td>{{ $r->email }}</td><td>{{ Str::limit($r->address,30) }}</td><td><a href="{{ route('admin.residents.edit', $r->id) }}" class="btn-modern btn-sm btn-outline">Edit</a> <form action="{{ route('admin.residents.destroy', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn-modern btn-sm btn-danger">Delete</button></form></td></tr>
    @empty <tr><td colspan="5">No residents.</td></tr> @endforelse
    </tbody></table>
</div></div>
@endsection
