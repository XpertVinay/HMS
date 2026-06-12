@extends('layouts.portal')
@section('title', 'My Advertisements')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">My Advertisements</h2>
    <button onclick="document.getElementById('adModal').style.display='block'" class="btn-modern" style="padding: 8px 16px;"><i class='bx bx-plus'></i> Submit New Ad</button>
</div>

@if(session('success'))
    <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

<!-- Add Ad Modal -->
<div id="adModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div class="modal-content" style="background-color: #fefefe; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 50%; border-radius: 8px;">
        <span onclick="document.getElementById('adModal').style.display='none'" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <h3>Submit Advertisement</h3>
        <form action="{{ route('vendor.advertisements.store') }}" method="POST" style="margin-top: 15px;">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Title</label>
                <input type="text" name="title" required class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" placeholder="E.g. 20% Off Deep Cleaning">
            </div>
            <div style="margin-bottom: 15px;">
                <label>Description</label>
                <textarea name="description" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; height: 80px;" placeholder="Optional details..." required></textarea>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Target URL</label>
                <input type="url" name="target_url" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;" placeholder="https://yourwebsite.com/offer" required>
            </div>
            <button type="submit" class="btn-modern" style="width: 100%; padding: 10px;">Submit for Approval (Fee: $10.00)</button>
        </form>
    </div>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Target URL</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($advertisements as $index => $ad)
                    <tr>
                        <td>{{ $advertisements->firstItem() + $index }}</td>
                        <td>{{ $ad->title }}</td>
                        <td>
                            @if($ad->target_url)
                                <a href="{{ $ad->target_url }}" target="_blank" style="color: #0d6efd; text-decoration: underline;">Visit</a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>${{ number_format($ad->advertisement_fee, 2) }}</td>
                        <td>
                            @if($ad->status === 'active')
                                <span style="background: #e6f4ea; color: #1e8e3e; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Active</span>
                            @elseif($ad->status === 'pending')
                                <span style="background: #fef7e0; color: #b06000; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Pending Approval</span>
                            @else
                                <span style="background: #fce8e6; color: #c5221f; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">{{ ucfirst($ad->status) }}</span>
                            @endif
                        </td>
                        <td>{{ $ad->created_at->format('Y-m-d') }}</td>
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
