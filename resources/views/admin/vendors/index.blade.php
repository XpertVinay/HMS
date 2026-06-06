@extends('layouts.portal')
@section('title', 'Vendors')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Vendors</h2>
    <a href="{{ route('admin.vendors.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Vendor</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table"><thead><tr><th>#</th><th>Business</th><th>Email</th><th>Actions</th></tr></thead><tbody>
    @forelse($vendors as $i => $v)<tr><td>{{ $i+1 }}</td><td>{{ $v->business_name }}</td><td>{{ $v->email }}</td><td><a href="{{ route('admin.vendors.edit', $v->id) }}" class="btn-modern btn-sm btn-outline">Edit</a> <form action="{{ route('admin.vendors.destroy', $v->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn-modern btn-sm btn-danger">Delete</button></form></td></tr>
    @empty <tr><td colspan="4">No vendors.</td></tr> @endforelse
    </tbody></table>
</div></div>
@endsection
