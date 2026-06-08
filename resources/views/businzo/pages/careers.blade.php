@extends('businzo.layouts.app')

@section('title', 'Careers at Businzo Technologies')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-purple-900/20 z-0"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
        <div data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-blue-500/20 bg-blue-500/5 text-blue-400 text-xs font-bold tracking-widest uppercase mb-6">
                Join the Team
            </div>
            <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-6">Build Platforms <span class="gradient-text">That Matter.</span></h1>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto font-light">Join a team that ships production software — web platforms, mobile apps, AI/ML systems, and custom tooling. Work on architecture, engineering, and delivery.</p>
        </div>
    </div>
</div>

<section class="py-24 relative z-10">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold font-['Outfit'] mb-4">Open Positions</h2>
            <p class="text-gray-400">Remote-first team delivering web, mobile, AI/ML, and custom software — Laravel, PHP 8.2, MySQL, Docker, and modern frontend stacks.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 max-w-4xl mx-auto">
            
            <!-- Job Card 1 -->
            <div class="glass-panel p-8 rounded-2xl border border-white/10 hover:border-blue-500/50 transition-colors group" data-aos="fade-up" data-aos-delay="100">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-bold">Engineering</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Remote</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Full-Time</span>
                        </div>
                        <h3 class="text-2xl font-bold font-['Outfit'] mb-2">Senior Laravel Architect</h3>
                        <p class="text-gray-400 text-sm">Lead platform development — architecture, modular services, security, CI quality gates, and scalable delivery. Laravel 12, PHPStan, PHPUnit.</p>
                    </div>
                    <a href="mailto:careers@businzo.com?subject=Application: Senior Laravel Architect" class="btn-outline px-6 py-3 rounded-full text-sm font-bold shrink-0 group-hover:bg-white group-hover:text-black transition-all">
                        Apply Now
                    </a>
                </div>
            </div>

            <!-- Job Card 2 -->
            <div class="glass-panel p-8 rounded-2xl border border-white/10 hover:border-purple-500/50 transition-colors group" data-aos="fade-up" data-aos-delay="150">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full bg-purple-500/10 text-purple-400 text-xs font-bold">Mobile</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Remote</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Full-Time</span>
                        </div>
                        <h3 class="text-2xl font-bold font-['Outfit'] mb-2">Mobile App Engineer (iOS / Android)</h3>
                        <p class="text-gray-400 text-sm">Build native mobile apps with robust backend integration — authentication, secure APIs, performance, and production observability.</p>
                    </div>
                    <a href="mailto:careers@businzo.com?subject=Application: Mobile App Engineer" class="btn-outline px-6 py-3 rounded-full text-sm font-bold shrink-0 group-hover:bg-white group-hover:text-black transition-all">
                        Apply Now
                    </a>
                </div>
            </div>

            <!-- Job Card 3 -->
            <div class="glass-panel p-8 rounded-2xl border border-white/10 hover:border-accent-500/50 transition-colors group" data-aos="fade-up" data-aos-delay="200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full bg-accent-500/10 text-accent-400 text-xs font-bold">AI / Data</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Remote</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Full-Time</span>
                        </div>
                        <h3 class="text-2xl font-bold font-['Outfit'] mb-2">AI Integration Engineer</h3>
                        <p class="text-gray-400 text-sm">Build RAG pipelines, document intelligence, and ML-powered automation. Integrate LLMs into real workflows with privacy and safety controls.</p>
                    </div>
                    <a href="mailto:careers@businzo.com?subject=Application: AI Integration Engineer" class="btn-outline px-6 py-3 rounded-full text-sm font-bold shrink-0 group-hover:bg-white group-hover:text-black transition-all">
                        Apply Now
                    </a>
                </div>
            </div>

            <!-- Job Card 4 -->
            <div class="glass-panel p-8 rounded-2xl border border-white/10 hover:border-red-400/50 transition-colors group" data-aos="fade-up" data-aos-delay="300">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full bg-red-500/10 text-red-400 text-xs font-bold">Design</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Remote</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Contract</span>
                        </div>
                        <h3 class="text-2xl font-bold font-['Outfit'] mb-2">UI/UX Product Designer</h3>
                        <p class="text-gray-400 text-sm">Design glassmorphism portals, theme presets, and mobile interfaces for multi-role SaaS platforms. Experience with admin dashboards and design systems preferred.</p>
                    </div>
                    <a href="mailto:careers@businzo.com?subject=Application: UI/UX Product Designer" class="btn-outline px-6 py-3 rounded-full text-sm font-bold shrink-0 group-hover:bg-white group-hover:text-black transition-all">
                        Apply Now
                    </a>
                </div>
            </div>

        </div>

        <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="400">
            <p class="text-gray-400 mb-4">Don't see a role that fits? We're always open to talented engineers who ship production code.</p>
            <a href="mailto:careers@businzo.com" class="text-primary hover:text-blue-400 font-bold transition-colors">Send us your resume →</a>
        </div>

    </div>
</section>
@endsection
