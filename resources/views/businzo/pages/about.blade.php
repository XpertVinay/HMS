@extends('businzo.layouts.app')

@section('title', 'Company & Mission')

@section('content')
<!-- Cinematic Parallax Banner -->
<div class="relative w-full h-[60vh] md:h-[70vh] min-h-[500px] overflow-hidden">
    <div class="absolute inset-0">
        <img src="{{ asset('assets/images/businzo/about.png') }}" alt="Businzo Engineering Team" class="w-full h-full object-cover object-center scale-105">
        <div class="absolute inset-0 bg-gradient-to-t from-background via-background/80 to-background/40"></div>
    </div>
    
    <div class="absolute inset-0 flex items-end pb-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 w-full">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-white/10 bg-white/5 backdrop-blur-md mb-6">
                <i class='bx bx-code-alt text-accent-400'></i>
                <span class="text-xs font-bold tracking-widest text-gray-300 uppercase">The Company</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-4 text-white" data-aos="fade-up">We Build <br><span class="text-gray-500">The Future.</span></h1>
        </div>
    </div>
</div>

<!-- Mission Section -->
<section class="py-24 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
            <div data-aos="fade-right">
                <h2 class="text-3xl font-bold mb-6 font-['Outfit']">Our Mission</h2>
                <div class="w-12 h-1 bg-accent-500 mb-8"></div>
                <p class="text-xl text-gray-400 leading-relaxed font-light mb-8">
                    At Businzo Technologies, we exist to accelerate digital transformation for forward-thinking organizations. We believe that exceptional software engineering is the ultimate competitive advantage in the modern economy.
                </p>
                <p class="text-gray-500 leading-relaxed">
                    By combining deep technical expertise, rigorous engineering standards, and cutting-edge technologies like Generative AI, we deliver solutions that are not just functional, but transformative.
                </p>
            </div>
            
            <div class="grid grid-cols-2 gap-6" data-aos="fade-left">
                <div class="glass-panel p-8 rounded-2xl flex flex-col justify-center">
                    <h4 class="text-5xl font-black text-white font-['Outfit'] tracking-tighter mb-2">150<span class="text-accent-500">+</span></h4>
                    <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Deployments</p>
                </div>
                <div class="glass-panel p-8 rounded-2xl flex flex-col justify-center">
                    <h4 class="text-5xl font-black text-white font-['Outfit'] tracking-tighter mb-2">50<span class="text-purple-500">+</span></h4>
                    <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Engineers</p>
                </div>
                <div class="glass-panel p-8 rounded-2xl flex flex-col justify-center">
                    <h4 class="text-5xl font-black text-white font-['Outfit'] tracking-tighter mb-2">12<span class="text-blue-500"></span></h4>
                    <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Countries</p>
                </div>
                <div class="glass-panel p-8 rounded-2xl flex flex-col justify-center">
                    <h4 class="text-5xl font-black text-white font-['Outfit'] tracking-tighter mb-2">0<span class="text-pink-500"></span></h4>
                    <p class="text-sm text-gray-500 font-bold uppercase tracking-wider">Compromises</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-32">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-20 max-w-3xl mx-auto" data-aos="fade-up">
            <h2 class="text-4xl font-black mb-6 font-['Outfit']">Engineering Principles</h2>
            <p class="text-gray-400 text-lg">The core values that dictate how we write code, design systems, and partner with our clients.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-white/10 transition-colors">
                    <i class='bx bx-rocket text-3xl text-gray-300'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Velocity & Precision</h4>
                <p class="text-gray-500 leading-relaxed">We ship fast without sacrificing quality. Our CI/CD pipelines and agile methodologies ensure rapid delivery of secure, tested code.</p>
            </div>
            
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-white/10 transition-colors">
                    <i class='bx bx-shield-quarter text-3xl text-gray-300'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Security by Default</h4>
                <p class="text-gray-500 leading-relaxed">Security isn't an afterthought. We implement SOC2 compliant infrastructure, end-to-end encryption, and zero-trust architectures.</p>
            </div>
            
            <div class="group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-white/10 transition-colors">
                    <i class='bx bx-chip text-3xl text-gray-300'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Future-Proof Tech</h4>
                <p class="text-gray-500 leading-relaxed">We avoid legacy traps. By leveraging modern frameworks and scalable cloud infrastructure, your software is built to last a decade, not a year.</p>
            </div>
        </div>
    </div>
</section>
@endsection
