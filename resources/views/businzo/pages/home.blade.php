@extends('businzo.layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-[90vh] flex items-center pt-20 overflow-hidden">
    <!-- Abstract Background -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-[var(--primary-bg)]"></div>
        <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-blue-600/20 rounded-full blur-[120px] mix-blend-screen opacity-50 animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-purple-600/20 rounded-full blur-[100px] mix-blend-screen opacity-50"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-left space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <span class="text-sm font-medium text-slate-300">Next-Gen Software Development</span>
                </div>
                
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight">
                    Transforming Ideas into <br>
                    <span class="gradient-text">Digital Reality</span>
                </h1>
                
                <p class="text-lg md:text-xl text-slate-400 max-w-xl leading-relaxed">
                    We engineer powerful web, mobile, and AI solutions that drive innovation and scale businesses globally. Partner with Businzo to build the future.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('businzo.estimate') }}" class="btn-gradient px-8 py-4 rounded-full text-white font-bold text-center flex items-center justify-center gap-2 group">
                        Start Your Project
                        <i class='bx bx-right-arrow-alt text-xl group-hover:translate-x-1 transition-transform'></i>
                    </a>
                    <a href="{{ route('businzo.services') }}" class="px-8 py-4 rounded-full text-white font-bold text-center border border-slate-700 hover:bg-slate-800 transition-colors flex items-center justify-center">
                        Explore Services
                    </a>
                </div>
                
                <div class="grid grid-cols-3 gap-6 pt-8 border-t border-slate-800">
                    <div>
                        <h4 class="text-3xl font-bold text-white font-['Outfit']">150+</h4>
                        <p class="text-sm text-slate-500 mt-1">Projects Delivered</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-bold text-white font-['Outfit']">50+</h4>
                        <p class="text-sm text-slate-500 mt-1">Expert Engineers</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-bold text-white font-['Outfit']">98%</h4>
                        <p class="text-sm text-slate-500 mt-1">Client Satisfaction</p>
                    </div>
                </div>
            </div>
            
            <div class="hidden lg:block relative">
                <!-- Floating Elements Container -->
                <div class="relative w-full h-[600px] flex items-center justify-center perspective-[1000px]">
                    <!-- Main Dashboard Mockup -->
                    <div class="absolute z-20 w-[110%] rounded-2xl bg-slate-900 border border-slate-700 shadow-2xl shadow-blue-900/20 overflow-hidden transform -rotate-y-12 rotate-x-6 hover:rotate-y-0 hover:rotate-x-0 transition-transform duration-700 ease-out">
                        <div class="h-8 bg-slate-800 border-b border-slate-700 flex items-center px-4 gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="p-4 grid grid-cols-3 gap-4">
                            <div class="col-span-2 space-y-4">
                                <div class="h-32 bg-slate-800 rounded-lg animate-pulse"></div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="h-24 bg-slate-800 rounded-lg animate-pulse"></div>
                                    <div class="h-24 bg-slate-800 rounded-lg animate-pulse"></div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="h-16 bg-slate-800 rounded-lg animate-pulse delay-75"></div>
                                <div class="h-40 bg-slate-800 rounded-lg animate-pulse delay-150"></div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Mobile Mockup -->
                    <div class="absolute z-30 bottom-10 -left-10 w-[200px] h-[400px] rounded-[2rem] bg-slate-900 border-4 border-slate-700 shadow-2xl shadow-purple-900/20 overflow-hidden transform translate-y-4 animate-[bounce_4s_infinite]">
                        <div class="absolute top-0 inset-x-0 h-6 bg-slate-900 z-10 flex justify-center rounded-b-xl">
                            <div class="w-16 h-4 bg-slate-800 rounded-b-xl mt-0"></div>
                        </div>
                        <div class="p-4 pt-10 space-y-4">
                            <div class="h-24 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl"></div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="h-16 bg-slate-800 rounded-xl"></div>
                                <div class="h-16 bg-slate-800 rounded-xl"></div>
                            </div>
                            <div class="h-8 bg-slate-800 rounded-full mt-4 w-3/4"></div>
                            <div class="h-4 bg-slate-800 rounded mt-2 w-1/2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Preview Section -->
<section class="py-24 bg-[var(--secondary-bg)] relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-sm font-bold tracking-widest text-blue-500 uppercase mb-3">Our Expertise</h2>
            <h3 class="text-4xl font-bold mb-6 font-['Outfit']">Comprehensive Software Solutions</h3>
            <p class="text-slate-400 text-lg">We deliver end-to-end development services to help you build, scale, and maintain high-performing digital products.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Web App -->
            <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700 hover:border-blue-500/50 transition-colors group">
                <div class="w-14 h-14 rounded-xl bg-blue-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class='bx bx-desktop text-3xl text-blue-500'></i>
                </div>
                <h4 class="text-xl font-bold mb-3 font-['Outfit']">Web Application</h4>
                <p class="text-slate-400 mb-6 line-clamp-3">Custom web applications built with modern frameworks like Laravel, React, and Vue.js. Fast, secure, and scalable solutions for enterprise needs.</p>
                <a href="{{ route('businzo.services') }}#web" class="text-blue-400 font-medium flex items-center gap-2 hover:text-blue-300">
                    Learn more <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

            <!-- Mobile App -->
            <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700 hover:border-purple-500/50 transition-colors group">
                <div class="w-14 h-14 rounded-xl bg-purple-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class='bx bx-mobile-alt text-3xl text-purple-500'></i>
                </div>
                <h4 class="text-xl font-bold mb-3 font-['Outfit']">Mobile Application</h4>
                <p class="text-slate-400 mb-6 line-clamp-3">Native and cross-platform mobile apps for iOS and Android. Engaging user experiences backed by robust mobile architecture.</p>
                <a href="{{ route('businzo.services') }}#mobile" class="text-purple-400 font-medium flex items-center gap-2 hover:text-purple-300">
                    Learn more <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

            <!-- AI App -->
            <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700 hover:border-emerald-500/50 transition-colors group lg:row-span-2">
                <div class="w-14 h-14 rounded-xl bg-emerald-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class='bx bx-brain text-3xl text-emerald-500'></i>
                </div>
                <h4 class="text-xl font-bold mb-3 font-['Outfit']">AI Application (RAG, OpenAI)</h4>
                <p class="text-slate-400 mb-6">Integrate intelligence into your workflows. We build Retrieval-Augmented Generation (RAG) systems, automated agents, and smart integrations using OpenAI and custom LLMs.</p>
                
                <div class="space-y-3 mb-6 mt-4">
                    <div class="flex items-center gap-3"><i class='bx bx-check text-emerald-500'></i> <span class="text-sm text-slate-300">Custom ChatGPT integrations</span></div>
                    <div class="flex items-center gap-3"><i class='bx bx-check text-emerald-500'></i> <span class="text-sm text-slate-300">Document Q&A systems</span></div>
                    <div class="flex items-center gap-3"><i class='bx bx-check text-emerald-500'></i> <span class="text-sm text-slate-300">AI-driven analytics</span></div>
                </div>

                <a href="{{ route('businzo.services') }}#ai" class="text-emerald-400 font-medium flex items-center gap-2 hover:text-emerald-300">
                    Learn more <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

            <!-- eCommerce -->
            <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700 hover:border-pink-500/50 transition-colors group">
                <div class="w-14 h-14 rounded-xl bg-pink-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class='bx bx-shopping-bag text-3xl text-pink-500'></i>
                </div>
                <h4 class="text-xl font-bold mb-3 font-['Outfit']">eCommerce Solutions</h4>
                <p class="text-slate-400 mb-6 line-clamp-3">High-converting online stores with custom payment gateways, inventory management, and seamless user journeys.</p>
                <a href="{{ route('businzo.services') }}#ecommerce" class="text-pink-400 font-medium flex items-center gap-2 hover:text-pink-300">
                    Learn more <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>

            <!-- Custom Software -->
            <div class="bg-slate-800/50 rounded-2xl p-8 border border-slate-700 hover:border-orange-500/50 transition-colors group">
                <div class="w-14 h-14 rounded-xl bg-orange-500/10 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class='bx bx-code-alt text-3xl text-orange-500'></i>
                </div>
                <h4 class="text-xl font-bold mb-3 font-['Outfit']">Custom Software</h4>
                <p class="text-slate-400 mb-6 line-clamp-3">Bespoke SaaS platforms, ERP systems, and internal tools tailored exactly to your business logic and operational needs.</p>
                <a href="{{ route('businzo.services') }}#custom" class="text-orange-400 font-medium flex items-center gap-2 hover:text-orange-300">
                    Learn more <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 to-purple-900/40 z-0"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-[500px] bg-blue-500/20 blur-[120px] rounded-full z-0"></div>
    
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h2 class="text-4xl md:text-5xl font-bold mb-6 font-['Outfit']">Ready to digitize your business?</h2>
        <p class="text-xl text-slate-300 mb-10 max-w-2xl mx-auto">Get a clear estimation of your project costs instantly using our custom estimation calculator.</p>
        
        <a href="{{ route('businzo.estimate') }}" class="btn-gradient px-10 py-5 rounded-full text-white font-bold text-lg inline-flex items-center gap-3 shadow-2xl">
            <i class='bx bx-calculator text-2xl'></i>
            Calculate Estimate Now
        </a>
    </div>
</section>
@endsection
