@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">My Reviews</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white text-center p-3">
                <h4>Average Rating</h4>
                <h1 class="display-4">{{ number_format($averageRating, 1) }} / 5</h1>
                <p>Based on {{ $totalReviews }} reviews</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Recent Reviews</h5>
        </div>
        <div class="card-body">
            @if($reviews->isEmpty())
                <p>No reviews received yet.</p>
            @else
                <div class="list-group">
                    @foreach($reviews as $review)
                    <div class="list-group-item list-group-item-action flex-column align-items-start">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                @for($i=1; $i<=5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="bx bxs-star text-warning"></i>
                                    @else
                                        <i class="bx bx-star text-warning"></i>
                                    @endif
                                @endfor
                            </h5>
                            <small>{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $review->review_text }}</p>
                        <small>From: {{ $review->member->name ?? 'Anonymous' }}</small>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-3">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
