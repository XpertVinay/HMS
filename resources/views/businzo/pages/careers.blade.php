@extends('businzo.layouts.app')

@section('title', 'Careers')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-900/20 to-purple-900/20 z-0"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
        <div data-aos="fade-up">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-blue-500/20 bg-blue-500/5 text-blue-400 text-xs font-bold tracking-widest uppercase mb-6">
                Join the Team
            </div>
            <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-6">Build the <span class="gradient-text">Future</span> with Us.</h1>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto font-light">We are always looking for exceptional engineers, designers, and visionaries to help us solve complex problems for global enterprises.</p>
        </div>
    </div>
</div>

<section class="py-24 relative z-10">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl font-bold font-['Outfit'] mb-4">Open Positions</h2>
            <p class="text-gray-400">Join our remote-first team of exceptional talent.</p>
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
                        <p class="text-gray-400 text-sm">Lead the architecture and development of high-scale enterprise applications.</p>
                    </div>
                    <a href="mailto:careers@businzo.com?subject=Application: Senior Laravel Architect" class="btn-outline px-6 py-3 rounded-full text-sm font-bold shrink-0 group-hover:bg-white group-hover:text-black transition-all">
                        Apply Now
                    </a>
                </div>
            </div>

            <!-- Job Card 2 -->
            <div class="glass-panel p-8 rounded-2xl border border-white/10 hover:border-accent-500/50 transition-colors group" data-aos="fade-up" data-aos-delay="200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full bg-accent-500/10 text-accent-400 text-xs font-bold">AI / Data</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Remote</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Full-Time</span>
                        </div>
                        <h3 class="text-2xl font-bold font-['Outfit'] mb-2">Machine Learning Engineer</h3>
                        <p class="text-gray-400 text-sm">Build and deploy custom LLMs and RAG pipelines for our enterprise clients.</p>
                    </div>
                    <a href="mailto:careers@businzo.com?subject=Application: Machine Learning Engineer" class="btn-outline px-6 py-3 rounded-full text-sm font-bold shrink-0 group-hover:bg-white group-hover:text-black transition-all">
                        Apply Now
                    </a>
                </div>
            </div>

            <!-- Job Card 3 -->
            <div class="glass-panel p-8 rounded-2xl border border-white/10 hover:border-purple-500/50 transition-colors group" data-aos="fade-up" data-aos-delay="300">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-3 py-1 rounded-full bg-purple-500/10 text-purple-400 text-xs font-bold">Design</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Remote</span>
                            <span class="px-3 py-1 rounded-full bg-white/5 text-gray-300 text-xs font-bold">Contract</span>
                        </div>
                        <h3 class="text-2xl font-bold font-['Outfit'] mb-2">UI/UX Product Designer</h3>
                        <p class="text-gray-400 text-sm">Create stunning, premium interfaces for complex software systems.</p>
                    </div>
                    <a href="mailto:careers@businzo.com?subject=Application: UI/UX Product Designer" class="btn-outline px-6 py-3 rounded-full text-sm font-bold shrink-0 group-hover:bg-white group-hover:text-black transition-all">
                        Apply Now
                    </a>
                </div>
            </div>

        </div>

        <div class="text-center mt-16" data-aos="fade-up" data-aos-delay="400">
            <p class="text-gray-400 mb-4">Don't see a role that fits? We're always open to talented people.</p>
            <a href="mailto:careers@businzo.com" class="text-primary hover:text-blue-400 font-bold transition-colors">Send us your resume -></a>
        </div>

    </div>
</section>
@endsection
