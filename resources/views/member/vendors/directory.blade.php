@extends('layouts.portal')
@section('title', 'Vendor Directory')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Approved Vendors</h2>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Business Name</th>
                    <th>Reviews</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $index => $vendor)
                    <tr>
                        <td>{{ $vendors->firstItem() + $index }}</td>
                        <td>{{ $vendor->business_name }}</td>
                        <td>{{ $vendor->reviews_count }} Review(s)</td>
                        <td>
                            <a href="{{ route('member.vendors.show', $vendor->id) }}" class="btn-modern" style="padding: 4px 8px; font-size: 13px;">View Profile</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px;">No vendors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div style="margin-top: 20px;">
            {{ $vendors->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
