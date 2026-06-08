@extends('businzo.layouts.app')

@section('title', 'Project Estimation Calculator')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/10">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-accent/10 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" data-aos="fade-up">
        <h1 class="text-4xl md:text-5xl font-bold font-['Outfit'] mb-6">Project <span class="gradient-text">Estimator</span></h1>
        <p class="text-xl text-muted max-w-3xl mx-auto">Get an instant ballpark estimate for your web platform, mobile app, AI/ML integration, or custom software development.</p>
    </div>
</div>

<section class="py-16 relative min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Calculator Form -->
            <div class="lg:col-span-2 space-y-8" id="calculator-form" data-aos="fade-right">
                
                <!-- Step 1: Project Type -->
                <div class="glass-panel p-6 md:p-8 rounded-2xl border border-white/10">
                    <h3 class="text-xl font-bold font-['Outfit'] mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center text-sm">1</span> 
                        Select Project Type
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <!-- Option Web -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="web" class="peer sr-only" checked>
                            <div class="p-4 rounded-xl border-2 border-white/10 bg-background peer-checked:border-primary peer-checked:bg-primary/10 transition-all hover:border-white/30 text-center">
                                <i class='bx bx-desktop text-3xl text-muted peer-checked:text-primary mb-2'></i>
                                <div class="font-bold text-sm">Web App</div>
                            </div>
                        </label>
                        <!-- Option Mobile -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="mobile" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-white/10 bg-background peer-checked:border-primary peer-checked:bg-primary/10 transition-all hover:border-white/30 text-center">
                                <i class='bx bx-mobile-alt text-3xl text-muted peer-checked:text-primary mb-2'></i>
                                <div class="font-bold text-sm">Mobile App</div>
                            </div>
                        </label>
                        <!-- Option AI -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="ai" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-white/10 bg-background peer-checked:border-primary peer-checked:bg-primary/10 transition-all hover:border-white/30 text-center">
                                <i class='bx bx-brain text-3xl text-muted peer-checked:text-primary mb-2'></i>
                                <div class="font-bold text-sm">AI / RAG</div>
                            </div>
                        </label>
                        <!-- Option eCommerce -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="ecommerce" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-white/10 bg-background peer-checked:border-primary peer-checked:bg-primary/10 transition-all hover:border-white/30 text-center">
                                <i class='bx bx-shopping-bag text-3xl text-muted peer-checked:text-primary mb-2'></i>
                                <div class="font-bold text-sm">eCommerce</div>
                            </div>
                        </label>
                        <!-- Option SaaS Platform -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="saas" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-white/10 bg-background peer-checked:border-primary peer-checked:bg-primary/10 transition-all hover:border-white/30 text-center">
                                <i class='bx bx-buildings text-3xl text-muted peer-checked:text-primary mb-2'></i>
                                <div class="font-bold text-sm">SaaS Platform</div>
                            </div>
                        </label>
                        <!-- Option Custom Software -->
                        <label class="cursor-pointer relative">
                            <input type="radio" name="project_type" value="custom" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-white/10 bg-background peer-checked:border-primary peer-checked:bg-primary/10 transition-all hover:border-white/30 text-center">
                                <i class='bx bx-code-alt text-3xl text-muted peer-checked:text-primary mb-2'></i>
                                <div class="font-bold text-sm">Custom Dev</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Project Complexity -->
                <div class="glass-panel p-6 md:p-8 rounded-2xl border border-white/10">
                    <h3 class="text-xl font-bold font-['Outfit'] mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-primary/20 text-primary flex items-center justify-center text-sm">2</span> 
                        Project Complexity
                    </h3>
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border border-white/10 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
                            <input type="radio" name="complexity" value="basic" class="w-5 h-5 text-primary bg-background border-white/20 focus:ring-primary" checked>
                            <div class="ml-4 flex-grow">
                                <div class="font-bold">Basic MVP</div>
                                <div class="text-sm text-muted">Core portal, auth, 1-2 modules (e.g. notices + helpdesk).</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-white/10 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
                            <input type="radio" name="complexity" value="medium" class="w-5 h-5 text-primary bg-background border-white/20 focus:ring-primary">
                            <div class="ml-4 flex-grow">
                                <div class="font-bold">Professional Platform</div>
                                <div class="text-sm text-muted">Multi-role portals, billing, vendor module, theme engine, mobile API.</div>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border border-white/10 rounded-xl cursor-pointer hover:bg-white/5 transition-colors">
                            <input type="radio" name="complexity" value="complex" class="w-5 h-5 text-primary bg-background border-white/20 focus:ring-primary">
                            <div class="ml-4 flex-grow">
                                <div class="font-bold">Enterprise SaaS</div>
                                <div class="text-sm text-muted">Multi-tenant, custom domains, super-admin, AI features, native mobile apps.</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 3: Additional Features -->
                <div class="glass-panel p-6 md:p-8 rounded-2xl border border-white/10">
                    <h3 class="text-xl font-bold font-['Outfit'] mb-2 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-accent/20 gradient-text-accent flex items-center justify-center text-sm">3</span> 
                        Additional Requirements
                    </h3>
                    <p class="text-sm text-muted mb-6 ml-10">Requirements are grouped by project type — essentials are pre-selected; optional add-ons can be toggled.</p>

                    <!-- Required -->
                    <div class="mb-8" id="features-required-section">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-primary/20 text-primary border border-primary/30">
                                <i class='bx bx-check-shield text-sm'></i> Required
                            </span>
                            <span class="text-xs text-muted">Included in the baseline scope for <span id="required-type-label" class="text-foreground font-medium">Web App</span></span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="features-required"></div>
                    </div>

                    <!-- Good to Have -->
                    <div id="features-optional-section">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-accent/20 gradient-text-accent border border-accent/30">
                                <i class='bx bx-plus-circle text-sm'></i> Good to Have
                            </span>
                            <span class="text-xs text-muted">Optional enhancements you can add to the scope</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="features-optional"></div>
                    </div>

                    <!-- Feature pool (moved into sections by JS) -->
                    <div class="hidden" id="features-pool">
                        <label class="feature-item flex items-center p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition-colors" data-feature="auth">
                            <input type="checkbox" name="features" value="auth" class="feature-checkbox w-5 h-5 rounded bg-background border-white/20">
                            <span class="ml-3 font-medium text-sm">User Authentication (Login/Register)</span>
                        </label>
                        <label class="feature-item flex items-center p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition-colors" data-feature="payment">
                            <input type="checkbox" name="features" value="payment" class="feature-checkbox w-5 h-5 rounded bg-background border-white/20">
                            <span class="ml-3 font-medium text-sm">Payment Gateway Integration</span>
                        </label>
                        <label class="feature-item flex items-center p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition-colors" data-feature="chat">
                            <input type="checkbox" name="features" value="chat" class="feature-checkbox w-5 h-5 rounded bg-background border-white/20">
                            <span class="ml-3 font-medium text-sm">Real-time Chat / Notifications</span>
                        </label>
                        <label class="feature-item flex items-center p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition-colors" data-feature="cms">
                            <input type="checkbox" name="features" value="cms" class="feature-checkbox w-5 h-5 rounded bg-background border-white/20">
                            <span class="ml-3 font-medium text-sm">Content Management System (CMS)</span>
                        </label>
                        <label class="feature-item flex items-center p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition-colors" data-feature="multi_language">
                            <input type="checkbox" name="features" value="multi_language" class="feature-checkbox w-5 h-5 rounded bg-background border-white/20">
                            <span class="ml-3 font-medium text-sm">Multi-language Support</span>
                        </label>
                        <label class="feature-item flex items-center p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition-colors" data-feature="admin">
                            <input type="checkbox" name="features" value="admin" class="feature-checkbox w-5 h-5 rounded bg-background border-white/20">
                            <span class="ml-3 font-medium text-sm">Advanced Admin Dashboard</span>
                        </label>
                        <label class="feature-item flex items-center p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition-colors" data-feature="multi_tenant">
                            <input type="checkbox" name="features" value="multi_tenant" class="feature-checkbox w-5 h-5 rounded bg-background border-white/20">
                            <span class="ml-3 font-medium text-sm">Multi-Tenant / Custom Domains</span>
                        </label>
                        <label class="feature-item flex items-center p-3 border border-white/10 rounded-lg cursor-pointer hover:bg-white/5 transition-colors" data-feature="theme">
                            <input type="checkbox" name="features" value="theme" class="feature-checkbox w-5 h-5 rounded bg-background border-white/20">
                            <span class="ml-3 font-medium text-sm">Theme Engine & White-Labeling</span>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Sticky Summary Sidebar -->
            <div class="lg:col-span-1" data-aos="fade-left" data-aos-delay="200">
                <div class="bg-gradient-to-b from-elevated to-background p-6 md:p-8 rounded-2xl border border-white/10 sticky top-24 shadow-2xl">
                    <h3 class="text-2xl font-bold font-['Outfit'] mb-6 text-center">Estimated Cost</h3>
                    
                    <div class="text-center mb-8">
                        <p class="text-sm text-muted mb-2 uppercase tracking-widest font-bold">Approximate Range</p>
                        <div class="text-4xl font-bold text-foreground mb-1" id="estimate-display">₹35,000</div>
                        <p class="text-sm text-muted">INR</p>
                    </div>

                    <div class="space-y-4 text-sm mb-8 border-t border-white/10 pt-6">
                        <div class="flex justify-between">
                            <span class="text-muted">Base Type:</span>
                            <span class="font-medium text-foreground" id="summary-type">Web App</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted">Complexity:</span>
                            <span class="font-medium text-foreground" id="summary-complexity">Basic MVP</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted">Est. Timeline:</span>
                            <span class="font-medium gradient-text-accent" id="summary-timeline">2-4 Weeks</span>
                        </div>
                    </div>

                    <p class="text-xs text-muted text-center mb-6 leading-relaxed">
                        *This is a rough estimate and not a final quote. Prices vary based on exact requirements, third-party services, and design specifications.
                    </p>

                    <button class="w-full btn-premium py-4 rounded-lg text-white font-bold text-lg" onclick="document.getElementById('contact-modal').classList.remove('hidden')">
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
    <div class="bg-white/5 border border-white/10 rounded-2xl p-8 max-w-md w-full mx-4 relative z-10 shadow-2xl">
        <button class="absolute top-4 right-4 text-muted hover:text-foreground" onclick="document.getElementById('contact-modal').classList.add('hidden')">
            <i class='bx bx-x text-2xl'></i>
        </button>
        <h3 class="text-2xl font-bold font-['Outfit'] mb-2">Almost there!</h3>
        <p class="text-muted mb-6">Leave your details and we'll send you a formal proposal based on your estimated requirements.</p>
        
        <form class="space-y-4" action="{{ route('businzo.contact') }}">
            <div>
                <input type="text" placeholder="Your Name" class="w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary" required>
            </div>
            <div>
                <input type="email" placeholder="Email Address" class="w-full bg-background border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary" required>
            </div>
            <button type="submit" class="w-full btn-premium py-3 rounded-lg text-white font-bold">
                Send Details
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const estimateConfig = @json($estimateConfig);
        const calculateUrl = @json(route('businzo.estimate.calculate'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

        const { features_by_type: featuresByType, short_type_labels: shortTypeLabels, project_types: projectTypes } = estimateConfig;

        const requiredItemClasses = [
            'border-primary/30', 'bg-primary/5', 'hover:bg-primary/10'
        ];
        const optionalItemClasses = [
            'border-white/10', 'hover:bg-white/5'
        ];

        // DOM Elements
        const form = document.getElementById('calculator-form');
        const display = document.getElementById('estimate-display');
        const summaryType = document.getElementById('summary-type');
        const summaryComplexity = document.getElementById('summary-complexity');
        const summaryTimeline = document.getElementById('summary-timeline');
        const requiredContainer = document.getElementById('features-required');
        const optionalContainer = document.getElementById('features-optional');
        const requiredSection = document.getElementById('features-required-section');
        const optionalSection = document.getElementById('features-optional-section');
        const requiredTypeLabel = document.getElementById('required-type-label');
        const featureItems = document.querySelectorAll('#features-pool .feature-item');

        function applyFeatureItemStyle(item, isRequired) {
            const checkbox = item.querySelector('.feature-checkbox');
            item.classList.remove(...requiredItemClasses, ...optionalItemClasses);
            checkbox.classList.remove('text-primary', 'focus:ring-primary', 'text-accent', 'focus:ring-accent');

            if (isRequired) {
                item.classList.add(...requiredItemClasses);
                checkbox.classList.add('text-primary', 'focus:ring-primary');
            } else {
                item.classList.add(...optionalItemClasses);
                checkbox.classList.add('text-accent', 'focus:ring-accent');
            }
        }

        function updateFeatureCategories(projectType, resetOptional = false) {
            const config = featuresByType[projectType];
            const optionalSelections = {};

            if (!resetOptional) {
                featureItems.forEach(item => {
                    const key = item.dataset.feature;
                    if (config.optional.includes(key)) {
                        optionalSelections[key] = item.querySelector('.feature-checkbox').checked;
                    }
                });
            }

            requiredContainer.innerHTML = '';
            optionalContainer.innerHTML = '';

            featureItems.forEach(item => {
                const key = item.dataset.feature;
                const checkbox = item.querySelector('.feature-checkbox');

                if (config.required.includes(key)) {
                    applyFeatureItemStyle(item, true);
                    checkbox.checked = true;
                    checkbox.disabled = false;
                    requiredContainer.appendChild(item);
                } else if (config.optional.includes(key)) {
                    applyFeatureItemStyle(item, false);
                    checkbox.disabled = false;
                    checkbox.checked = resetOptional ? false : (optionalSelections[key] ?? false);
                    optionalContainer.appendChild(item);
                }
            });

            requiredTypeLabel.textContent = shortTypeLabels[projectType];
            requiredSection.classList.toggle('hidden', config.required.length === 0);
            optionalSection.classList.toggle('hidden', config.optional.length === 0);
        }

        let calculateRequestId = 0;

        async function calculateEstimate() {
            const selectedType = document.querySelector('input[name="project_type"]:checked').value;
            const selectedComplexity = document.querySelector('input[name="complexity"]:checked').value;
            const selectedFeatures = Array.from(
                document.querySelectorAll('input[name="features"]:checked')
            ).map(input => input.value);

            const requestId = ++calculateRequestId;
            display.classList.add('opacity-60');

            try {
                const response = await fetch(calculateUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        project_type: selectedType,
                        complexity: selectedComplexity,
                        features: selectedFeatures,
                    }),
                });

                if (!response.ok) {
                    throw new Error('Estimate request failed');
                }

                const data = await response.json();

                if (requestId !== calculateRequestId) {
                    return;
                }

                display.innerHTML = `₹${data.total_min_formatted} <span class="text-xl text-muted font-normal block mt-1">- ₹${data.total_max_formatted}</span>`;
                summaryType.textContent = data.type_label;
                summaryComplexity.textContent = data.complexity_label;
                summaryTimeline.textContent = data.timeline;
            } catch (error) {
                if (requestId === calculateRequestId) {
                    display.textContent = 'Unable to calculate';
                }
            } finally {
                if (requestId === calculateRequestId) {
                    display.classList.remove('opacity-60');
                }
            }
        }

        // Check if URL has a type parameter (e.g. from services page)
        const urlParams = new URLSearchParams(window.location.search);
        const typeParam = urlParams.get('type');
        if (typeParam && projectTypes.includes(typeParam)) {
            const radio = document.querySelector(`input[name="project_type"][value="${typeParam}"]`);
            if (radio) radio.checked = true;
        }

        function onProjectTypeChange() {
            const selectedType = document.querySelector('input[name="project_type"]:checked').value;
            updateFeatureCategories(selectedType, true);
            calculateEstimate();
        }

        // Project type drives feature categories; other inputs recalculate only
        form.querySelectorAll('input[name="project_type"]').forEach(input => {
            input.addEventListener('change', onProjectTypeChange);
        });

        form.querySelectorAll('input[name="complexity"], input[name="features"]').forEach(input => {
            input.addEventListener('change', calculateEstimate);
        });

        // Initial setup
        const initialType = document.querySelector('input[name="project_type"]:checked').value;
        updateFeatureCategories(initialType, false);
        calculateEstimate();
    });
</script>
@endpush
