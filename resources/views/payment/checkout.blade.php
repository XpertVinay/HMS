@extends('layouts.public')

@section('title', 'Payment Checkout')

@section('content')
<div class="relative pt-20 pb-32 flex content-center items-center justify-center min-h-[85vh] -mt-[72px]">
    <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop');">
        <span id="blackOverlay" class="w-full h-full absolute opacity-80 bg-gradient-to-r from-[var(--secondary)] to-[var(--primary)]/90 mix-blend-multiply"></span>
    </div>
    
    <div class="container relative mx-auto px-4 z-10 flex justify-center mt-12 mb-12">
        <div class="glass-card rounded-[24px] p-6 sm:p-8 md:p-10 w-full max-w-lg relative overflow-hidden text-center">
            <h2 class="text-2xl font-bold text-white mb-2">Complete Your Payment</h2>
            <p class="text-white/80 mb-8">{{ $description ?? 'Please complete the payment to proceed.' }}</p>
            
            <div class="bg-white/10 rounded-xl p-6 mb-8 border border-white/20">
                <div class="text-3xl font-bold text-white mb-1">₹{{ number_format($amount, 2) }}</div>
                <div class="text-sm text-white/60">Amount to pay</div>
            </div>

            <form action="{{ $callbackUrl }}" method="POST" id="razorpay-form">
                @csrf
                <script
                    src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{ config('razorpay.key') }}"
                    data-amount="{{ $amount * 100 }}"
                    data-currency="INR"
                    data-order_id="{{ $orderId }}"
                    data-buttontext="Pay With Razorpay"
                    data-name="{{ config('app.name', 'Platform') }}"
                    data-description="{{ $description ?? 'Payment' }}"
                    data-prefill.name="{{ $name ?? '' }}"
                    data-prefill.email="{{ $email ?? '' }}"
                    data-theme.color="#4f46e5">
                </script>
            </form>
            
            <!-- Hide default razorpay button and show a custom one if desired, or let razorpay show its button -->
            <style>
                .razorpay-payment-button {
                    background: linear-gradient(to right, var(--primary), var(--secondary));
                    color: white;
                    padding: 12px 24px;
                    border-radius: 9999px;
                    font-weight: 600;
                    width: 100%;
                    transition: all 0.3s ease;
                    border: none;
                    cursor: pointer;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                }
                .razorpay-payment-button:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                }
            </style>
        </div>
    </div>
</div>
@endsection
