@extends('businzo.layouts.app')

@section('title', 'Portfolio — Businzo Technologies')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-gradient-to-r from-primary/20 to-accent/20 z-0"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10" data-aos="fade-up">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-white/10 bg-white/5 backdrop-blur-md mb-6">
            <i class='bx bx-briefcase text-muted'></i>
            <span class="text-xs font-bold tracking-widest text-muted uppercase">Selected Work</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-6">Software that <span class="text-subtle">delivers outcomes.</span></h1>
        <p class="text-xl text-muted max-w-3xl font-light">Case studies across AI-powered platforms, scalable SaaS, mobile products, and intelligent automation — built for security, scale, and business growth.</p>
    </div>
</div>

<section class="py-24 relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('businzo.portfolio.rcms') }}" class="glass-panel p-8 rounded-3xl hover:bg-white/[0.02] transition-colors group" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-start justify-between gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-primary/15 border border-white/10 flex items-center justify-center">
                        <i class='bx bx-buildings text-2xl text-primary'></i>
                    </div>
                    <span class="text-xs font-bold tracking-widest text-muted uppercase">Web + Mobile + SaaS</span>
                </div>
                <h3 class="text-2xl font-black font-['Outfit'] mt-6 mb-3">Residential Community Management System</h3>
                <p class="text-muted leading-relaxed mb-6">A multi-role platform for communities: admin dashboards, billing workflows, helpdesk ticketing, vendor ecosystem, and mobile-ready APIs.</p>
                <div class="text-foreground font-semibold flex items-center gap-2 group-hover:text-primary transition-colors">
                    View case study <i class='bx bx-right-arrow-alt text-xl'></i>
                </div>
            </a>

            <div class="glass-panel p-8 rounded-3xl opacity-70" data-aos="fade-up" data-aos-delay="150">
                <div class="flex items-start justify-between gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <i class='bx bx-globe text-2xl text-muted'></i>
                    </div>
                    <span class="text-xs font-bold tracking-widest text-muted uppercase">Web App</span>
                </div>
                <h3 class="text-2xl font-black font-['Outfit'] mt-6 mb-3">Enterprise Portal</h3>
                <p class="text-muted leading-relaxed mb-6">Role-based workflows, dashboards, and reporting with secure authentication and scalable APIs.</p>
                <div class="text-muted text-sm">More case studies coming soon.</div>
            </div>

            <div class="glass-panel p-8 rounded-3xl opacity-70" data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-start justify-between gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <i class='bx bx-brain text-2xl text-primary-light'></i>
                    </div>
                    <span class="text-xs font-bold tracking-widest text-muted uppercase">AI / ML</span>
                </div>
                <h3 class="text-2xl font-black font-['Outfit'] mt-6 mb-3">AI & MCP Automation</h3>
                <p class="text-muted leading-relaxed mb-6">LLM agents, MCP integrations, RAG pipelines, and intelligent workflow automation that reduce manual overhead and accelerate decisions.</p>
                <div class="text-muted text-sm">More case studies coming soon.</div>
            </div>
        </div>
    </div>
</section>

<section class="py-24 border-t border-white/5 bg-background">
    <div class="max-w-4xl mx-auto text-center px-6" data-aos="zoom-in">
        <h2 class="text-3xl font-black mb-6 font-['Outfit']">Ready for results like these?</h2>
        <p class="text-muted mb-8">Let's scope your AI-powered platform — secure, scalable, and built to grow your business.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('businzo.estimate') }}" class="btn-premium px-8 py-3 rounded-full font-bold inline-flex items-center justify-center gap-2">
                <i class='bx bx-rocket'></i> Start Your Project
            </a>
            <a href="{{ route('businzo.contact') }}" class="btn-outline px-8 py-3 rounded-full font-bold inline-flex items-center justify-center">
                Book a Consultation
            </a>
        </div>
    </div>
</section>
@endsection

