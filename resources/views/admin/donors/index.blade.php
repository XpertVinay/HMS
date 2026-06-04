@extends('layouts.portal')
@section('title', 'Donors')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Donors</h2>
    <a href="{{ route('admin.donors.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Donor</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table"><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Amount</th><th>Date</th><th>Actions</th></tr></thead><tbody>
    @forelse($donors as $i => $d)<tr><td>{{ $i+1 }}</td><td>{{ $d->name }}</td><td>{{ $d->email }}</td><td>₹{{ number_format($d->amount,2) }}</td><td>{{ $d->donation_date?->format('M d, Y') }}</td><td><a href="{{ route('admin.donors.edit', $d->id) }}" class="btn-modern btn-sm btn-outline">Edit</a> <form action="{{ route('admin.donors.destroy', $d->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn-modern btn-sm btn-danger">Delete</button></form></td></tr>
    @empty <tr><td colspan="6">No donors.</td></tr> @endforelse
    </tbody></table>
</div></div>
@endsection
