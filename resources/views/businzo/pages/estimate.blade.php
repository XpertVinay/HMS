@extends('businzo.layouts.app')

@section('title', 'Project Estimation Calculator')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-slate-900 border-b border-slate-800">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/10 to-emerald-900/10 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold font-['Outfit'] mb-6">Estimation <span class="gradient-text">Calculator</span></h1>
        <p class="text-xl text-slate-400 max-w-3xl mx-auto">Get an instant ballpark estimate for your software development project.</p>
    </div>
</div>

<section class="py-16 relative min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Calculator Form -->
            <div class="lg:col-span-2 space-y-8" id="calculator-form">
                
                <!-- Step 1: Project Type -->
                <div class="bg-slate-800/50 p-6 md:p-8 rounded-2xl border border-slate-700">
                    <h3 class="text-xl font-bold font-['Outfit'] mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-500 flex items-center justify-center text-sm">1</span> 
                        Select Project Type
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <!-- Option Web -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="web" class="peer sr-only" checked>
                            <div class="p-4 rounded-xl border-2 border-slate-700 bg-slate-900 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 transition-all hover:border-slate-500 text-center">
                                <i class='bx bx-desktop text-3xl text-slate-400 peer-checked:text-blue-500 mb-2'></i>
                                <div class="font-bold text-sm">Web App</div>
                            </div>
                        </label>
                        <!-- Option Mobile -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="mobile" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-700 bg-slate-900 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 transition-all hover:border-slate-500 text-center">
                                <i class='bx bx-mobile-alt text-3xl text-slate-400 peer-checked:text-blue-500 mb-2'></i>
                                <div class="font-bold text-sm">Mobile App</div>
                            </div>
                        </label>
                        <!-- Option AI -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="ai" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-700 bg-slate-900 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 transition-all hover:border-slate-500 text-center">
                                <i class='bx bx-brain text-3xl text-slate-400 peer-checked:text-blue-500 mb-2'></i>
                                <div class="font-bold text-sm">AI / RAG</div>
                            </div>
                        </label>
                        <!-- Option eCommerce -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="ecommerce" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-700 bg-slate-900 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 transition-all hover:border-slate-500 text-center">
                                <i class='bx bx-shopping-bag text-3xl text-slate-400 peer-checked:text-blue-500 mb-2'></i>
                                <div class="font-bold text-sm">eCommerce</div>
                            </div>
                        </label>
                        <!-- Option Custom Software -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="custom" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-slate-700 bg-slate-900 peer-checked:border-blue-500 peer-checked:bg-blue-500/10 transition-all hover:border-slate-500 text-center">
                                <i class='bx bx-code-alt text-3xl text-slate-400 peer-checked:text-blue-500 mb-2'></i>
                                <div class="font-bold text-sm">Custom Dev</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Project Complexity -->
                <div class="bg-slate-800/50 p-6 md:p-8 rounded-2xl border border-slate-700">
                    <h3 class="text-xl font-bold font-['Outfit'] mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-purple-500/20 text-purple-500 flex items-center justify-center text-sm">2</span> 
                        Project Complexity
                    </h3>
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border border-slate-700 rounded-xl cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="radio" name="complexity" value="basic" class="w-5 h-5 text-purple-500 bg-slate-900 border-slate-600 focus:ring-purple-500" checked>
                            <div class="ml-4 flex-grow">
                                <div class="font-bold">Basic Minimum Viable Product (MVP)</div>
                                <div class="text-sm text-slate-400">Core features, simple UI, standard functionality.</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-slate-700 rounded-xl cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="radio" name="complexity" value="medium" class="w-5 h-5 text-purple-500 bg-slate-900 border-slate-600 focus:ring-purple-500">
                            <div class="ml-4 flex-grow">
                                <div class="font-bold">Professional Application</div>
                                <div class="text-sm text-slate-400">Custom UI/UX, user roles, API integrations, admin panel.</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-slate-700 rounded-xl cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="radio" name="complexity" value="complex" class="w-5 h-5 text-purple-500 bg-slate-900 border-slate-600 focus:ring-purple-500">
                            <div class="ml-4 flex-grow">
                                <div class="font-bold">Enterprise System</div>
                                <div class="text-sm text-slate-400">Complex architecture, high security, scalability, custom algorithms.</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 3: Additional Features -->
                <div class="bg-slate-800/50 p-6 md:p-8 rounded-2xl border border-slate-700">
                    <h3 class="text-xl font-bold font-['Outfit'] mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-emerald-500/20 text-emerald-500 flex items-center justify-center text-sm">3</span> 
                        Additional Requirements
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center p-3 border border-slate-700 rounded-lg cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="features" value="auth" class="w-5 h-5 rounded text-emerald-500 bg-slate-900 border-slate-600 focus:ring-emerald-500" checked>
                            <span class="ml-3 font-medium text-sm">User Authentication (Login/Register)</span>
                        </label>
                        <label class="flex items-center p-3 border border-slate-700 rounded-lg cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="features" value="payment" class="w-5 h-5 rounded text-emerald-500 bg-slate-900 border-slate-600 focus:ring-emerald-500">
                            <span class="ml-3 font-medium text-sm">Payment Gateway Integration</span>
                        </label>
                        <label class="flex items-center p-3 border border-slate-700 rounded-lg cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="features" value="chat" class="w-5 h-5 rounded text-emerald-500 bg-slate-900 border-slate-600 focus:ring-emerald-500">
                            <span class="ml-3 font-medium text-sm">Real-time Chat / Notifications</span>
                        </label>
                        <label class="flex items-center p-3 border border-slate-700 rounded-lg cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="features" value="cms" class="w-5 h-5 rounded text-emerald-500 bg-slate-900 border-slate-600 focus:ring-emerald-500">
                            <span class="ml-3 font-medium text-sm">Content Management System (CMS)</span>
                        </label>
                        <label class="flex items-center p-3 border border-slate-700 rounded-lg cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="features" value="multi_language" class="w-5 h-5 rounded text-emerald-500 bg-slate-900 border-slate-600 focus:ring-emerald-500">
                            <span class="ml-3 font-medium text-sm">Multi-language Support</span>
                        </label>
                        <label class="flex items-center p-3 border border-slate-700 rounded-lg cursor-pointer hover:bg-slate-800 transition-colors">
                            <input type="checkbox" name="features" value="admin" class="w-5 h-5 rounded text-emerald-500 bg-slate-900 border-slate-600 focus:ring-emerald-500">
                            <span class="ml-3 font-medium text-sm">Advanced Admin Dashboard</span>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Sticky Summary Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-b from-slate-800 to-slate-900 p-6 md:p-8 rounded-2xl border border-slate-700 sticky top-24 shadow-2xl">
                    <h3 class="text-2xl font-bold font-['Outfit'] mb-6 text-center">Estimated Cost</h3>
                    
                    <div class="text-center mb-8">
                        <p class="text-sm text-slate-400 mb-2 uppercase tracking-widest font-bold">Approximate Range</p>
                        <div class="text-4xl font-bold text-white mb-1" id="estimate-display">₹35,000</div>
                        <p class="text-sm text-slate-400">INR</p>
                    </div>

                    <div class="space-y-4 text-sm mb-8 border-t border-slate-700 pt-6">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Base Type:</span>
                            <span class="font-medium text-white" id="summary-type">Web App</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Complexity:</span>
                            <span class="font-medium text-white" id="summary-complexity">Basic MVP</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Est. Timeline:</span>
                            <span class="font-medium text-blue-400" id="summary-timeline">2-4 Weeks</span>
                        </div>
                    </div>

                    <p class="text-xs text-slate-500 text-center mb-6 leading-relaxed">
                        *This is a rough estimate and not a final quote. Prices vary based on exact requirements, third-party services, and design specifications.
                    </p>

                    <button class="w-full btn-gradient py-4 rounded-lg text-white font-bold text-lg" onclick="document.getElementById('contact-modal').classList.remove('hidden')">
                        Request Formal Proposal
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Simple Contact Modal -->
<div id="contact-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="document.getElementById('contact-modal').classList.add('hidden')"></div>
    <div class="bg-slate-800 border border-slate-700 rounded-2xl p-8 max-w-md w-full mx-4 relative z-10 shadow-2xl">
        <button class="absolute top-4 right-4 text-slate-400 hover:text-white" onclick="document.getElementById('contact-modal').classList.add('hidden')">
            <i class='bx bx-x text-2xl'></i>
        </button>
        <h3 class="text-2xl font-bold font-['Outfit'] mb-2">Almost there!</h3>
        <p class="text-slate-400 mb-6">Leave your details and we'll send you a formal proposal based on your estimated requirements.</p>
        
        <form class="space-y-4" action="{{ route('businzo.contact') }}">
            <div>
                <input type="text" placeholder="Your Name" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500" required>
            </div>
            <div>
                <input type="email" placeholder="Email Address" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-blue-500" required>
            </div>
            <button type="submit" class="w-full btn-gradient py-3 rounded-lg text-white font-bold">
                Send Details
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Base Pricing rules as per user request
        const basePrices = {
            web: 35000,
            mobile: 65000,
            ai: 100000,
            ecommerce: 80000,
            custom: 120000
        };

        const typeLabels = {
            web: 'Web Application',
            mobile: 'Mobile Application',
            ai: 'AI / RAG App',
            ecommerce: 'eCommerce Solution',
            custom: 'Custom Software'
        };

        const complexityMultipliers = {
            basic: 1,
            medium: 1.8,
            complex: 3.5
        };

        const complexityLabels = {
            basic: 'Basic MVP',
            medium: 'Professional App',
            complex: 'Enterprise System'
        };

        const timelines = {
            basic: '2-4 Weeks',
            medium: '6-10 Weeks',
            complex: '3-6 Months'
        };

        const featurePrices = {
            auth: 5000,
            payment: 15000,
            chat: 25000,
            cms: 20000,
            multi_language: 10000,
            admin: 15000
        };

        // DOM Elements
        const form = document.getElementById('calculator-form');
        const display = document.getElementById('estimate-display');
        const summaryType = document.getElementById('summary-type');
        const summaryComplexity = document.getElementById('summary-complexity');
        const summaryTimeline = document.getElementById('summary-timeline');

        function calculateEstimate() {
            // Get selected type
            const selectedType = document.querySelector('input[name="project_type"]:checked').value;
            // Get selected complexity
            const selectedComplexity = document.querySelector('input[name="complexity"]:checked').value;
            
            // Calculate Base * Multiplier
            let total = basePrices[selectedType] * complexityMultipliers[selectedComplexity];

            // Add Features
            const selectedFeatures = document.querySelectorAll('input[name="features"]:checked');
            selectedFeatures.forEach(feature => {
                total += featurePrices[feature.value];
            });

            // Format number
            const formattedTotal = new Intl.NumberFormat('en-IN').format(Math.round(total));

            // Create a range string (total to total + 20%)
            const maxTotal = new Intl.NumberFormat('en-IN').format(Math.round(total * 1.2));
            
            // Update UI
            display.innerHTML = `₹${formattedTotal} <span class="text-xl text-slate-400 font-normal block mt-1">- ₹${maxTotal}</span>`;
            summaryType.textContent = typeLabels[selectedType];
            summaryComplexity.textContent = complexityLabels[selectedComplexity];
            summaryTimeline.textContent = timelines[selectedComplexity];
        }

        // Check if URL has a type parameter (e.g. from services page)
        const urlParams = new URLSearchParams(window.location.search);
        const typeParam = urlParams.get('type');
        if (typeParam && basePrices[typeParam]) {
            const radio = document.querySelector(`input[name="project_type"][value="${typeParam}"]`);
            if (radio) radio.checked = true;
        }

        // Add event listeners to all inputs
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('change', calculateEstimate);
        });

        // Initial calculation
        calculateEstimate();
    });
</script>
@endpush
