@extends('layouts.portal')
@section('title', 'Vendor Advertisements')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Vendor Advertisements</h2>
</div>

@if(session('success'))
    <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vendor</th>
                    <th>Title</th>
                    <th>Target URL</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th class="no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($advertisements as $index => $ad)
                    <tr>
                        <td>{{ $advertisements->firstItem() + $index }}</td>
                        <td>{{ $ad->vendor->business_name ?? 'N/A' }}</td>
                        <td>{{ $ad->title }}</td>
                        <td>
                            @if($ad->target_url)
                                <a href="{{ $ad->target_url }}" target="_blank" style="color: #0d6efd; text-decoration: underline;">Link</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($ad->status === 'active')
                                <span style="background: #e6f4ea; color: #1e8e3e; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Active</span>
                            @elseif($ad->status === 'pending')
                                <span style="background: #fef7e0; color: #b06000; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Pending</span>
                            @else
                                <span style="background: #fce8e6; color: #c5221f; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">{{ ucfirst($ad->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $ad->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($ad->status === 'pending')
                                <form action="{{ route('admin.advertisements.approve', $ad->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-modern" style="background: #28a745; color: white; padding: 4px 8px; font-size: 12px; border: none; cursor: pointer;">Approve</button>
                                </form>
                                <form action="{{ route('admin.advertisements.reject', $ad->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-modern" style="background: #dc3545; color: white; padding: 4px 8px; font-size: 12px; border: none; cursor: pointer;">Reject</button>
                                </form>
                            @else
                                <span style="color: #6c757d; font-size: 13px;">No Action</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 20px;">
            {{ $advertisements->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
