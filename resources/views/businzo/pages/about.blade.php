@extends('businzo.layouts.app')

@section('title', 'About Businzo — AI-Powered Software Engineering')

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
                <i class='bx bx-code-alt gradient-text-accent-light'></i>
                <span class="text-xs font-bold tracking-widest text-muted uppercase">Businzo Technologies</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-4 text-foreground" data-aos="fade-up">We Engineer <br><span class="gradient-text-accent">AI-Powered Software.</span></h1>
            <p class="text-lg text-muted max-w-xl font-light" data-aos="fade-up" data-aos-delay="100">Production-ready platforms with MCP integrations, intelligent automation, and enterprise-grade security — built to accelerate business growth.</p>
        </div>
    </div>
</div>

<!-- Mission Section -->
<section class="py-24 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
            <div data-aos="fade-right">
                <h2 class="text-3xl font-bold mb-6 font-['Outfit']">Our Mission</h2>
                <div class="w-12 h-1 bg-accent mb-8"></div>
                <p class="text-xl text-muted leading-relaxed font-light mb-8">
                    Businzo Technologies turns complex business challenges into secure, scalable software. We specialize in AI-powered platforms, MCP integrations, and intelligent automation for teams that need more than off-the-shelf tools.
                </p>
                <p class="text-muted leading-relaxed mb-6">
                    From discovery to deployment, we deliver end-to-end product engineering — UX, architecture, backend, mobile, DevOps, and AI/ML. Every engagement is outcome-driven: faster operations, smarter workflows, and platforms built to scale.
                </p>
                <p class="text-muted leading-relaxed">
                    Our engineering standards are non-negotiable — production-ready CI/CD, automated testing, enterprise security, and cloud-native architecture on every project we ship.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 mt-10">
                    <a href="{{ route('businzo.estimate') }}" class="btn-premium px-6 py-3 rounded-full font-bold inline-flex items-center justify-center gap-2 w-fit">
                        Start Your Project <i class='bx bx-right-arrow-alt'></i>
                    </a>
                    <a href="{{ route('businzo.contact') }}" class="btn-outline px-6 py-3 rounded-full font-bold inline-flex items-center justify-center w-fit">
                        Book a Consultation
                    </a>
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-6" data-aos="fade-left">
                <div class="glass-panel p-8 rounded-2xl flex flex-col justify-center">
                    <h4 class="text-5xl font-black text-foreground font-['Outfit'] tracking-tighter mb-2">6<span class="gradient-gradient-text-accent">+</span></h4>
                    <p class="text-sm text-muted font-bold uppercase tracking-wider">User Portals</p>
                </div>
                <div class="glass-panel p-8 rounded-2xl flex flex-col justify-center">
                    <h4 class="text-5xl font-black text-foreground font-['Outfit'] tracking-tighter mb-2">36<span class="text-accent-light">+</span></h4>
                    <p class="text-sm text-muted font-bold uppercase tracking-wider">Data Models</p>
                </div>
                <div class="glass-panel p-8 rounded-2xl flex flex-col justify-center">
                    <h4 class="text-5xl font-black text-foreground font-['Outfit'] tracking-tighter mb-2">25<span class="text-primary">+</span></h4>
                    <p class="text-sm text-muted font-bold uppercase tracking-wider">DB Migrations</p>
                </div>
                <div class="glass-panel p-8 rounded-2xl flex flex-col justify-center">
                    <h4 class="text-5xl font-black text-foreground font-['Outfit'] tracking-tighter mb-2">1<span class="text-primary-light"></span></h4>
                    <p class="text-sm text-muted font-bold uppercase tracking-wider">Codebase, Many Tenants</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What We Build Section -->
<section class="py-24 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-16 max-w-3xl mx-auto" data-aos="fade-up">
            <h2 class="text-4xl font-black mb-6 font-['Outfit']">What We Deliver</h2>
            <p class="text-muted text-lg">Four disciplines — each focused on outcomes that drive business growth.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="glass-panel p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="100">
                <i class='bx bx-globe text-4xl text-primary mb-6'></i>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Web & SaaS Platforms</h4>
                <p class="text-muted leading-relaxed mb-4">Launch scalable SaaS products and enterprise portals that handle growth — multi-tenant, secure, and cloud-native.</p>
                <ul class="text-sm text-muted space-y-2">
                    <li class="flex items-center gap-2"><i class='bx bx-check text-primary'></i> Multi-tenant architecture</li>
                    <li class="flex items-center gap-2"><i class='bx bx-check text-primary'></i> Enterprise security & RBAC</li>
                    <li class="flex items-center gap-2"><i class='bx bx-check text-primary'></i> Production-ready CI/CD</li>
                </ul>
            </div>

            <div class="glass-panel p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="200">
                <i class='bx bx-mobile-alt text-4xl gradient-text-accent mb-6'></i>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Mobile Products</h4>
                <p class="text-muted leading-relaxed mb-4">Native apps that drive user engagement and retention — secure backends, offline UX, and push notifications built in.</p>
                <ul class="text-sm text-muted space-y-2">
                    <li class="flex items-center gap-2"><i class='bx bx-check gradient-text-accent'></i> iOS (Swift) & Android (Kotlin)</li>
                    <li class="flex items-center gap-2"><i class='bx bx-check gradient-text-accent'></i> Secure API integration</li>
                    <li class="flex items-center gap-2"><i class='bx bx-check gradient-text-accent'></i> Offline-friendly UX</li>
                </ul>
            </div>

            <div class="glass-panel p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="300">
                <i class='bx bx-brain text-4xl gradient-text-accent mb-6'></i>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">AI, MCP & Automation</h4>
                <p class="text-muted leading-relaxed mb-4">Production-grade AI — LLM agents, MCP integrations, RAG pipelines, and intelligent workflows that reduce manual overhead.</p>
                <ul class="text-sm text-muted space-y-2">
                    <li class="flex items-center gap-2"><i class='bx bx-check gradient-text-accent-light'></i> MCP & agent integrations</li>
                    <li class="flex items-center gap-2"><i class='bx bx-check gradient-text-accent-light'></i> RAG & document intelligence</li>
                    <li class="flex items-center gap-2"><i class='bx bx-check gradient-text-accent-light'></i> Workflow automation</li>
                </ul>
            </div>
            <div class="glass-panel p-8 rounded-2xl" data-aos="fade-up" data-aos-delay="350">
                <i class='bx bx-cube-alt text-4xl text-primary-light mb-6'></i>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Custom Software</h4>
                <p class="text-muted leading-relaxed mb-4">Domain-specific platforms when generic tools fall short — tailored workflows, white-label SaaS, and competitive differentiation.</p>
                <ul class="text-sm text-muted space-y-2">
                    <li class="flex items-center gap-2"><i class='bx bx-check text-primary-light'></i> Domain-driven design</li>
                    <li class="flex items-center gap-2"><i class='bx bx-check text-primary-light'></i> Integrations & automation</li>
                    <li class="flex items-center gap-2"><i class='bx bx-check text-primary-light'></i> Maintainable codebases</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Engineering Principles Section -->
<section class="py-32">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="text-center mb-20 max-w-3xl mx-auto" data-aos="fade-up">
            <h2 class="text-4xl font-black mb-6 font-['Outfit']">Engineering Principles</h2>
            <p class="text-muted text-lg">The engineering standards behind every production-ready product we ship — security, scalability, and quality at every layer.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group" data-aos="fade-up" data-aos-delay="100">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-white/10 transition-colors">
                    <i class='bx bx-badge-check text-3xl text-muted'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Quality by Design</h4>
                <p class="text-muted leading-relaxed">Reliability is built in, not added later. We use automated testing, peer code review, static analysis, and CI/CD pipelines on every change — so defects are caught early and releases go out on a predictable, evidence-backed cadence.</p>
            </div>
            
            <div class="group" data-aos="fade-up" data-aos-delay="200">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-white/10 transition-colors">
                    <i class='bx bx-shield-quarter text-3xl text-muted'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Security by Default</h4>
                <p class="text-muted leading-relaxed">Authentication, authorization, encryption, and audit logging are part of the foundation — not a late-stage add-on. We apply least-privilege access, secure API design, and compliance-aware data handling so your product stays protected as users and data grow.</p>
            </div>
            
            <div class="group" data-aos="fade-up" data-aos-delay="300">
                <div class="w-16 h-16 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mb-6 group-hover:bg-white/10 transition-colors">
                    <i class='bx bx-layer text-3xl text-muted'></i>
                </div>
                <h4 class="text-xl font-bold mb-4 font-['Outfit']">Architecture for Growth</h4>
                <p class="text-muted leading-relaxed">We favor modular, API-first systems with clear separation of concerns — containerized for cloud deployment, observable in production, and ready to scale horizontally. Your software handles today's load and adapts to new features and integrations without costly rewrites.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 border-t border-white/5 bg-elevated">
    <div class="max-w-4xl mx-auto text-center px-6" data-aos="zoom-in">
        <h2 class="text-3xl md:text-4xl font-black mb-6 font-['Outfit']">Ready to build with us?</h2>
        <p class="text-muted mb-8 max-w-2xl mx-auto">Let's turn your vision into production-ready, AI-powered software — secure, scalable, and built for growth.</p>
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
