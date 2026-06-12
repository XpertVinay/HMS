@extends('layouts.portal')
@section('title', $vendor->business_name)
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">{{ $vendor->business_name }}</h2>
    <a href="{{ route('member.vendors.directory') }}" class="btn-modern" style="background: #6c757d; border: none; padding: 6px 12px; color: white;">Back</a>
</div>

@if(session('success'))
    <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #721c24; background-color: #f8d7da; border-color: #f5c6cb;">
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <!-- Vendor Info -->
    <div class="box">
        <h3 style="font-size: 16px; margin-bottom: 15px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 10px;">Profile Information</h3>
        <p><strong>Email:</strong> {{ $vendor->email }}</p>
        <p><strong>Tasks Completed:</strong> {{ $vendor->total_tasks_completed }}</p>
        <p><strong>Average Rating:</strong> {{ number_format($averageRating, 1) }} / 5.0 ({{ count($vendor->reviews) }} reviews)</p>
    </div>

    <!-- Active Advertisements -->
    <div class="box">
        <h3 style="font-size: 16px; margin-bottom: 15px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 10px;">Active Offers</h3>
        @forelse($vendor->advertisements as $ad)
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 10px;">
                <h4 style="font-weight: bold; font-size: 15px;">{{ $ad->title }}</h4>
                <p style="margin-top: 5px; color: #666; font-size: 14px;">{{ $ad->description }}</p>
                @if($ad->target_url)
                    <a href="{{ $ad->target_url }}" target="_blank" style="display: inline-block; margin-top: 10px; color: #0d6efd; text-decoration: underline;">Claim Offer</a>
                @endif
            </div>
        @empty
            <p style="color: #666;">No active offers at the moment.</p>
        @endforelse
    </div>
</div>

<div class="sales-boxes" style="grid-template-columns: 1fr; margin-top: 20px;">
    <!-- Reviews Section -->
    <div class="box">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">
            <h3 style="font-size: 16px; font-weight: bold;">Resident Reviews</h3>
            <button onclick="document.getElementById('reviewModal').style.display='block'" class="btn-modern" style="padding: 6px 12px; font-size: 13px;">Write a Review</button>
        </div>
        
        @forelse($vendor->reviews as $review)
            <div style="border-bottom: 1px solid #f0f0f0; padding-bottom: 15px; margin-bottom: 15px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <strong style="color: #333;">{{ $review->member->username ?? 'Resident' }}</strong>
                    <span style="color: #f39c12; font-size: 18px;">
                        {!! str_repeat('★', $review->rating) !!}{!! str_repeat('☆', 5 - $review->rating) !!}
                    </span>
                </div>
                <p style="color: #555; margin-top: 5px;">{{ $review->review_text }}</p>
                <small style="color: #999;">{{ $review->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <p style="color: #666; text-align: center; padding: 20px;">No reviews yet. Be the first to review!</p>
        @endforelse
    </div>
</div>

<!-- Write Review Modal -->
<div id="reviewModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
    <div class="modal-content" style="background-color: #fefefe; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 40%; border-radius: 8px;">
        <span onclick="document.getElementById('reviewModal').style.display='none'" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <h3 style="margin-bottom: 15px;">Write a Review</h3>
        <form action="{{ route('member.vendors.review.store', $vendor->id) }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label>Rating (1-5)</label>
                <select name="rating" required class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="5">★★★★★ - Excellent</option>
                    <option value="4">★★★★☆ - Good</option>
                    <option value="3">★★★☆☆ - Average</option>
                    <option value="2">★★☆☆☆ - Poor</option>
                    <option value="1">★☆☆☆☆ - Terrible</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label>Review Detail</label>
                <textarea name="review_text" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; height: 100px;" placeholder="Tell us about your experience..." required></textarea>
            </div>
            <button type="submit" class="btn-modern" style="width: 100%; padding: 10px;">Submit Review</button>
        </form>
    </div>
</div>
@endsection
