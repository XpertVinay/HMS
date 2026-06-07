@extends('businzo.layouts.app')

@section('title', 'Our Services')

@section('content')
<!-- Page Header -->
<div class="pt-32 pb-20 relative overflow-hidden bg-slate-900 border-b border-slate-800">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-50 z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold font-['Outfit'] mb-6">Our <span class="gradient-text">Services</span></h1>
        <p class="text-xl text-slate-400 max-w-3xl mx-auto">Comprehensive software engineering and AI solutions tailored to drive growth and efficiency.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-32">

    <!-- Web Application -->
    <section id="web" class="scroll-mt-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-sm font-medium mb-6">
                    <i class='bx bx-desktop'></i> Web Development
                </div>
                <h2 class="text-3xl font-bold font-['Outfit'] mb-6">Custom Web Applications</h2>
                <p class="text-slate-400 mb-6 leading-relaxed">
                    We build dynamic, responsive, and highly secure web applications tailored to your business needs. Using modern tech stacks like Laravel, Vue.js, and React, we ensure that your platform is scalable and performs exceptionally under high traffic.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-blue-500 mt-1'></i>
                        <span class="text-slate-300">Single Page Applications (SPAs)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-blue-500 mt-1'></i>
                        <span class="text-slate-300">Progressive Web Apps (PWAs)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-blue-500 mt-1'></i>
                        <span class="text-slate-300">Enterprise Portals & Dashboards</span>
                    </li>
                </ul>
                <a href="{{ route('businzo.estimate') }}?type=web" class="text-blue-400 hover:text-blue-300 font-medium inline-flex items-center gap-2 group">
                    Get an Estimate <i class='bx bx-right-arrow-alt group-hover:translate-x-1 transition-transform'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2 h-[350px] bg-slate-800 rounded-2xl border border-slate-700 relative overflow-hidden flex items-center justify-center">
                <div class="absolute inset-0 bg-blue-500/5 mix-blend-overlay"></div>
                <i class='bx bx-code-alt text-8xl text-slate-700'></i>
            </div>
        </div>
    </section>

    <!-- Mobile Application -->
    <section id="mobile" class="scroll-mt-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="h-[350px] bg-slate-800 rounded-2xl border border-slate-700 relative overflow-hidden flex items-center justify-center">
                <div class="absolute inset-0 bg-purple-500/5 mix-blend-overlay"></div>
                <i class='bx bx-mobile text-8xl text-slate-700'></i>
            </div>
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-purple-500/10 text-purple-400 text-sm font-medium mb-6">
                    <i class='bx bx-mobile-alt'></i> Mobile Development
                </div>
                <h2 class="text-3xl font-bold font-['Outfit'] mb-6">Native & Hybrid Mobile Apps</h2>
                <p class="text-slate-400 mb-6 leading-relaxed">
                    Capture your mobile audience with stunning iOS and Android applications. We specialize in both native development and cross-platform solutions like React Native and Flutter to deliver smooth, app-store ready products.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-purple-500 mt-1'></i>
                        <span class="text-slate-300">iOS (Swift) & Android (Kotlin) apps</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-purple-500 mt-1'></i>
                        <span class="text-slate-300">Cross-Platform Development</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-purple-500 mt-1'></i>
                        <span class="text-slate-300">App UI/UX Design & Prototyping</span>
                    </li>
                </ul>
                <a href="{{ route('businzo.estimate') }}?type=mobile" class="text-purple-400 hover:text-purple-300 font-medium inline-flex items-center gap-2 group">
                    Get an Estimate <i class='bx bx-right-arrow-alt group-hover:translate-x-1 transition-transform'></i>
                </a>
            </div>
        </div>
    </section>

    <!-- AI Application -->
    <section id="ai" class="scroll-mt-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-sm font-medium mb-6">
                    <i class='bx bx-brain'></i> AI Solutions
                </div>
                <h2 class="text-3xl font-bold font-['Outfit'] mb-6">AI Applications (RAG & OpenAI)</h2>
                <p class="text-slate-400 mb-6 leading-relaxed">
                    Leverage the power of Generative AI. We build custom conversational agents and automated workflows utilizing Large Language Models (LLMs). From standard OpenAI integrations to complex Retrieval-Augmented Generation (RAG) architecture using your private data.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-emerald-500 mt-1'></i>
                        <span class="text-slate-300">Custom ChatGPT & Vector Databases</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-emerald-500 mt-1'></i>
                        <span class="text-slate-300">Document analysis and Q&A systems (RAG)</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-emerald-500 mt-1'></i>
                        <span class="text-slate-300">Predictive Machine Learning models</span>
                    </li>
                </ul>
                <a href="{{ route('businzo.estimate') }}?type=ai" class="text-emerald-400 hover:text-emerald-300 font-medium inline-flex items-center gap-2 group">
                    Get an Estimate <i class='bx bx-right-arrow-alt group-hover:translate-x-1 transition-transform'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2 h-[350px] bg-slate-800 rounded-2xl border border-slate-700 relative overflow-hidden flex items-center justify-center">
                <div class="absolute inset-0 bg-emerald-500/5 mix-blend-overlay"></div>
                <i class='bx bx-network-chart text-8xl text-slate-700'></i>
            </div>
        </div>
    </section>

    <!-- eCommerce Solutions -->
    <section id="ecommerce" class="scroll-mt-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="h-[350px] bg-slate-800 rounded-2xl border border-slate-700 relative overflow-hidden flex items-center justify-center">
                <div class="absolute inset-0 bg-pink-500/5 mix-blend-overlay"></div>
                <i class='bx bx-shopping-bag text-8xl text-slate-700'></i>
            </div>
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-pink-500/10 text-pink-400 text-sm font-medium mb-6">
                    <i class='bx bx-cart'></i> eCommerce
                </div>
                <h2 class="text-3xl font-bold font-['Outfit'] mb-6">eCommerce Solutions</h2>
                <p class="text-slate-400 mb-6 leading-relaxed">
                    Build high-converting online stores. We create robust B2B and B2C eCommerce platforms with secure payment gateways, inventory management, and seamless integrations with external CRMs and ERPs.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-pink-500 mt-1'></i>
                        <span class="text-slate-300">Custom Online Storefronts</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-pink-500 mt-1'></i>
                        <span class="text-slate-300">Multi-vendor Marketplaces</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-pink-500 mt-1'></i>
                        <span class="text-slate-300">Payment & Shipping Integrations</span>
                    </li>
                </ul>
                <a href="{{ route('businzo.estimate') }}?type=ecommerce" class="text-pink-400 hover:text-pink-300 font-medium inline-flex items-center gap-2 group">
                    Get an Estimate <i class='bx bx-right-arrow-alt group-hover:translate-x-1 transition-transform'></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Custom Software -->
    <section id="custom" class="scroll-mt-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="order-2 lg:order-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/10 text-orange-400 text-sm font-medium mb-6">
                    <i class='bx bx-cog'></i> Custom Dev
                </div>
                <h2 class="text-3xl font-bold font-['Outfit'] mb-6">Custom Software Development</h2>
                <p class="text-slate-400 mb-6 leading-relaxed">
                    Off-the-shelf software doesn't always cut it. We architect and build complex SaaS products, internal management tools, and customized platforms designed perfectly for your unique operational workflows.
                </p>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-orange-500 mt-1'></i>
                        <span class="text-slate-300">SaaS Architecture & Development</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-orange-500 mt-1'></i>
                        <span class="text-slate-300">Internal ERP & CRM Systems</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class='bx bx-check-circle text-orange-500 mt-1'></i>
                        <span class="text-slate-300">API Development & Legacy Modernization</span>
                    </li>
                </ul>
                <a href="{{ route('businzo.estimate') }}?type=custom" class="text-orange-400 hover:text-orange-300 font-medium inline-flex items-center gap-2 group">
                    Get an Estimate <i class='bx bx-right-arrow-alt group-hover:translate-x-1 transition-transform'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2 h-[350px] bg-slate-800 rounded-2xl border border-slate-700 relative overflow-hidden flex items-center justify-center">
                <div class="absolute inset-0 bg-orange-500/5 mix-blend-overlay"></div>
                <i class='bx bx-slider text-8xl text-slate-700'></i>
            </div>
        </div>
    </section>

</div>
@endsection
