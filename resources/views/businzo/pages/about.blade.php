@extends('businzo.layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Page Header -->
<div class="pt-32 pb-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-blue-900/20 to-transparent z-0"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <h1 class="text-4xl md:text-5xl font-bold font-['Outfit'] mb-6">About <span class="gradient-text">Businzo</span></h1>
        <p class="text-xl text-slate-400 max-w-3xl mx-auto">We are a team of passionate engineers, designers, and strategists dedicated to building world-class software that transforms businesses.</p>
    </div>
</div>

<!-- Content Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
            <div>
                <div class="h-[400px] rounded-2xl bg-slate-800 border border-slate-700 overflow-hidden relative group">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/20 to-purple-500/20 mix-blend-overlay z-10"></div>
                    <!-- Placeholder for team image or abstract graphic -->
                    <div class="w-full h-full flex flex-col items-center justify-center bg-slate-900 relative">
                        <i class='bx bx-code-block text-8xl text-slate-700 absolute z-0 opacity-20'></i>
                        <div class="z-20 text-center">
                            <h3 class="text-2xl font-bold font-['Outfit'] text-white">Innovation at Core</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <h2 class="text-3xl font-bold font-['Outfit']">Our Mission</h2>
                <p class="text-slate-400 text-lg leading-relaxed">
                    At Businzo, our mission is to empower organizations with scalable, robust, and innovative technology solutions. We believe in writing clean code, designing intuitive interfaces, and implementing AI strategies that provide a real competitive advantage.
                </p>
                <div class="pt-6 grid grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-4xl font-bold text-blue-500 font-['Outfit'] mb-2">10+</h4>
                        <p class="text-slate-400">Years of Experience</p>
                    </div>
                    <div>
                        <h4 class="text-4xl font-bold text-purple-500 font-['Outfit'] mb-2">Global</h4>
                        <p class="text-slate-400">Clientele Base</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold font-['Outfit'] mb-4">Why Choose Us?</h2>
            <p class="text-slate-400 max-w-2xl mx-auto">We combine deep technical expertise with a strong focus on business outcomes.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-slate-800/30 p-8 rounded-2xl border border-slate-700/50">
                <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center mb-6">
                    <i class='bx bx-rocket text-2xl text-blue-500'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Agile Delivery</h4>
                <p class="text-slate-400">We work in iterative sprints, ensuring rapid delivery of value and allowing flexibility for evolving requirements.</p>
            </div>
            
            <div class="bg-slate-800/30 p-8 rounded-2xl border border-slate-700/50">
                <div class="w-12 h-12 rounded-full bg-purple-500/20 flex items-center justify-center mb-6">
                    <i class='bx bx-shield-quarter text-2xl text-purple-500'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Enterprise Security</h4>
                <p class="text-slate-400">Security is built-in from day one. We follow best practices to ensure your data and infrastructure are protected.</p>
            </div>
            
            <div class="bg-slate-800/30 p-8 rounded-2xl border border-slate-700/50">
                <div class="w-12 h-12 rounded-full bg-emerald-500/20 flex items-center justify-center mb-6">
                    <i class='bx bx-bulb text-2xl text-emerald-500'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Future-Proof Tech</h4>
                <p class="text-slate-400">We leverage the latest stable technologies including AI and modern frameworks to keep you ahead of the curve.</p>
            </div>
        </div>
    </div>
</section>
@endsection
