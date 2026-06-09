@extends('layouts.public')
@section('title', 'Donors')
@section('content')
<div class="container mx-auto px-4 max-w-7xl py-12">
    <div class="text-center mb-16 relative">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Our Generous Donors</h1>
        <p class="text-lg text-gray-600 mb-8">Thank you for supporting our community</p>
        
        <button onclick="document.getElementById('donateModal').classList.remove('hidden')" class="bg-gradient-to-r from-[var(--primary)] to-[var(--secondary)] text-white px-8 py-3 rounded-full font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1">
            Donate Now
        </button>
    </div>

    <!-- Donation Modal -->
    <div id="donateModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-3xl p-8 max-w-md w-full mx-4 shadow-2xl relative">
            <button onclick="document.getElementById('donateModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                <i class='bx bx-x text-2xl'></i>
            </button>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Make a Donation</h2>
            <p class="text-gray-500 mb-6 text-sm">Your contribution helps us grow and serve the community better.</p>

            <form action="{{ route('donate.initiate') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] outline-none" placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Your Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] outline-none" placeholder="john@example.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Amount (₹)</label>
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="preset_amount" value="500" class="peer sr-only" onchange="document.getElementById('custom_amount').value = this.value">
                            <div class="text-center py-2 border rounded-xl peer-checked:bg-[var(--primary)] peer-checked:text-white peer-checked:border-[var(--primary)] transition-colors hover:bg-gray-50">₹500</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="preset_amount" value="1000" class="peer sr-only" onchange="document.getElementById('custom_amount').value = this.value">
                            <div class="text-center py-2 border rounded-xl peer-checked:bg-[var(--primary)] peer-checked:text-white peer-checked:border-[var(--primary)] transition-colors hover:bg-gray-50">₹1000</div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="preset_amount" value="5000" class="peer sr-only" onchange="document.getElementById('custom_amount').value = this.value">
                            <div class="text-center py-2 border rounded-xl peer-checked:bg-[var(--primary)] peer-checked:text-white peer-checked:border-[var(--primary)] transition-colors hover:bg-gray-50">₹5000</div>
                        </label>
                    </div>
                    <input type="number" name="amount" id="custom_amount" required min="1" class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)] outline-none" placeholder="Or enter custom amount">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-[var(--primary)] to-[var(--secondary)] text-white py-3 rounded-xl font-bold mt-4 hover:opacity-90 transition-opacity shadow-md">
                    Proceed to Pay
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($donors as $donor)
        <div class="bg-white hover:bg-gray-50 transition-colors shadow-sm border border-gray-100 rounded-2xl p-6 flex items-center gap-5 hover:shadow-md">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[var(--primary)] to-purple-500 flex items-center justify-center text-white font-bold text-2xl shrink-0 shadow-inner">
                {{ substr($donor->name, 0, 1) }}
            </div>
            <div class="flex-grow overflow-hidden">
                <h3 class="text-lg font-bold text-gray-900 truncate">{{ $donor->name }}</h3>
                <p class="text-[var(--primary)] font-semibold mt-1">₹{{ number_format($donor->amount, 2) }}</p>
            </div>
            <div class="text-right shrink-0">
                <span class="text-xs text-gray-400 block">{{ $donor->created_at?->format('M d, Y') }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 border-dashed">
            <i class='bx bx-heart text-5xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">No donors listed yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
