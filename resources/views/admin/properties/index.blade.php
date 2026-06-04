@extends('layouts.portal')
@section('title', 'Properties')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Properties</h2>
    <a href="{{ route('admin.properties.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Property</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table"><thead><tr><th>#</th><th>Address</th><th>Type</th><th>Owner</th><th>Resident</th><th>Actions</th></tr></thead><tbody>
    @forelse($properties as $i => $p)<tr><td>{{ $i+1 }}</td><td>{{ Str::limit($p->address,30) }}</td><td>{{ $p->type }}</td><td>{{ $p->owner->username ?? '-' }}</td><td>{{ $p->resident->username ?? '-' }}</td><td><a href="{{ route('admin.properties.edit', $p->id) }}" class="btn-modern btn-sm btn-outline">Edit</a> <form action="{{ route('admin.properties.destroy', $p->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn-modern btn-sm btn-danger">Delete</button></form></td></tr>
    @empty <tr><td colspan="6">No properties.</td></tr> @endforelse
    </tbody></table>
</div></div>
@endsection
