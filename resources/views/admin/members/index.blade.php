@extends('layouts.portal')
@section('title', 'Members')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Members</h2>
    <a href="{{ route('admin.members.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Add Member</a>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table">
            <thead><tr><th>#</th><th>Username</th><th>Email</th><th>Address</th><th>Phone</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($members as $i => $member)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $member->username }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ Str::limit($member->address, 30) }}</td>
                    <td>{{ $member->phone }}</td>
                    <td>
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="btn-modern btn-sm btn-outline">Edit</a>
                        <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this member?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-modern btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6">No members found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
