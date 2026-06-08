@extends('businzo.layouts.app')

@section('title', 'Expertise — Web, Mobile & AI Development')

@section('content')
<!-- Page Header -->
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)] z-0"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10" data-aos="fade-up">
        <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-6 max-w-4xl">Software development <span class="text-subtle">services</span> for modern teams.</h1>
        <p class="text-xl text-muted max-w-2xl font-light">Web applications, mobile apps, AI/ML engineering, and custom software — delivered with clean architecture, secure implementation, and production-ready deployment.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-24 space-y-40">

    <!-- Web Architecture -->
    <section id="web" class="scroll-mt-32 relative">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-primary/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-primary/20 bg-primary/5 text-primary-light text-xs font-bold tracking-widest uppercase mb-8">
                    <i class='bx bx-code'></i> Web Architecture
                </div>
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Enterprise Web Platforms</h2>
                <p class="text-muted mb-8 leading-relaxed font-light text-lg">
                    We engineer secure, scalable web applications: dashboards, internal tools, portals, marketplaces, and SaaS platforms. Our focus is performance, maintainability, and operational reliability — from database design to CI/CD.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-check text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Scalable APIs & Architecture</h4>
                            <p class="text-sm text-muted">Clean boundaries, modular services, and API-first design that supports rapid iteration.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-check text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Role-Based Access Control</h4>
                            <p class="text-sm text-muted">Secure authentication, permissions, and audit-friendly workflows.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-check text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Production-Ready Delivery</h4>
                            <p class="text-sm text-muted">Dockerized environments, automated tests, static analysis, and safe deployments.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=web" class="btn-outline px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2 hover:bg-white hover:text-black hover:border-white transition-all">
                    Estimate Web Project <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="glass-panel rounded-3xl p-2 relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary/20 to-transparent opacity-50 rounded-3xl blur-xl"></div>
                    <div class="bg-[#0a0a0a] border border-white/10 rounded-2xl h-[400px] flex flex-col overflow-hidden relative z-10">
                        <div class="h-10 border-b border-white/10 flex items-center px-4 gap-2 bg-[#111111]">
                            <div class="w-3 h-3 rounded-full bg-primary/50"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                            <span class="text-xs text-muted ml-2 font-mono">app.company.com — Dashboard</span>
                        </div>
                        <div class="flex-grow p-6">
                            <div class="space-y-3 mb-6">
                                <div class="text-xs text-muted uppercase tracking-wider">Admin Portal</div>
                                <div class="grid grid-cols-3 gap-2">
                                    <div class="h-16 rounded-lg bg-primary/10 border border-primary/20 flex flex-col items-center justify-center">
                                        <i class='bx bx-bell text-primary-light'></i>
                                        <span class="text-[10px] text-muted mt-1">Notices</span>
                                    </div>
                                    <div class="h-16 rounded-lg bg-white/5 border border-white/10 flex flex-col items-center justify-center">
                                        <i class='bx bx-pie-chart-alt-2 text-muted'></i>
                                        <span class="text-[10px] text-muted mt-1">Billing</span>
                                    </div>
                                    <div class="h-16 rounded-lg bg-white/5 border border-white/10 flex flex-col items-center justify-center">
                                        <i class='bx bx-support text-muted'></i>
                                        <span class="text-[10px] text-muted mt-1">Helpdesk</span>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="h-3 bg-white/5 rounded w-full"></div>
                                <div class="h-3 bg-white/5 rounded w-4/5"></div>
                                <div class="h-3 bg-white/5 rounded w-3/5"></div>
                            </div>
                            <div class="h-24 bg-gradient-to-r from-primary/10 to-transparent rounded mt-6 border border-primary/20 flex items-center px-4">
                                <div class="text-xs text-muted"><span class="text-primary-light font-bold">42</span> open tickets · <span class="text-accent-light font-bold">99.9%</span> uptime</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Engineering -->
    <section id="mobile" class="scroll-mt-32 relative">
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-accent/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-1 lg:order-1" data-aos="fade-right">
                <div class="glass-panel rounded-3xl p-2 relative w-3/4 mx-auto lg:w-full lg:mx-0">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/20 to-transparent opacity-50 rounded-3xl blur-xl"></div>
                    <div class="bg-[#0a0a0a] border border-white/10 rounded-3xl h-[500px] flex flex-col overflow-hidden relative z-10 w-[250px] mx-auto my-4 shadow-2xl">
                        <div class="h-6 w-32 bg-black rounded-b-xl mx-auto absolute top-0 left-1/2 -translate-x-1/2 z-20"></div>
                        <div class="flex-grow p-4 pt-10 flex flex-col gap-4 relative">
                            <div class="text-center mb-2">
                                <div class="text-xs text-muted">Mobile App</div>
                                <div class="text-sm font-bold text-white">Green Valley Society</div>
                            </div>
                            <div class="h-24 rounded-xl bg-gradient-to-br from-accent/20 to-primary/20 border border-white/5 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-xs text-muted">Maintenance Due</div>
                                    <div class="text-lg font-black text-white">₹4,500</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="h-16 rounded-xl bg-white/5 flex flex-col items-center justify-center">
                                    <i class='bx bx-support gradient-text-accent text-lg'></i>
                                    <span class="text-[10px] text-muted mt-1">Helpdesk</span>
                                </div>
                                <div class="h-16 rounded-xl bg-white/5 flex flex-col items-center justify-center">
                                    <i class='bx bx-group text-primary-light text-lg'></i>
                                    <span class="text-[10px] text-muted mt-1">Community</span>
                                </div>
                            </div>
                            <div class="h-10 rounded-xl bg-accent/20 border border-accent/30 flex items-center justify-center text-xs font-bold gradient-text-accent mt-auto">Pay Now</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-2 lg:order-2" data-aos="fade-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-accent/20 bg-accent/5 gradient-text-accent text-xs font-bold tracking-widest uppercase mb-8">
                    <i class='bx bx-mobile-alt'></i> Mobile Engineering
                </div>
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Native & API-First Mobile</h2>
                <p class="text-muted mb-8 leading-relaxed font-light text-lg">
                    We build polished mobile products that feel native and stay reliable at scale. From secure authentication and API integration to offline-friendly UX — we deliver apps that users keep.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bxl-apple text-xl text-white'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">iOS Native (Swift)</h4>
                            <p class="text-sm text-muted">Polished native UI with push notifications, biometric login, and offline-capable bill viewing.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bxl-android text-xl text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Android Native (Kotlin)</h4>
                            <p class="text-sm text-muted">Material Design interfaces with Jetpack Compose, connected to the same JWT API endpoints.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-qr text-xl text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Secure Mobile + Backend</h4>
                            <p class="text-sm text-muted">JWT/OAuth, robust APIs, telemetry, and scalable backend services.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=mobile" class="btn-outline px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2 hover:bg-white hover:text-black hover:border-white transition-all">
                    Estimate Mobile App <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        </div>
    </section>

    <!-- AI Application -->
    <section id="ai" class="scroll-mt-32 relative">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-accent/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-accent/20 bg-accent/5 gradient-text-accent text-xs font-bold tracking-widest uppercase mb-8">
                    <i class='bx bx-brain'></i> AI & Data
                </div>
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Practical AI Integration</h2>
                <p class="text-muted mb-8 leading-relaxed font-light text-lg">
                    We deliver AI/ML that is useful in production: classification, forecasting, recommendations, document intelligence, and LLM-powered assistants — integrated into your product with privacy and safety controls.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-data text-xl text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">RAG over Private Records</h4>
                            <p class="text-sm text-muted">Semantic search across society documents, bylaws, and maintenance history — answers grounded in your data, not the public internet.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-bot text-xl text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Smart Workflow Automation</h4>
                            <p class="text-sm text-muted">AI-assisted ticket classification, approval routing, and vendor matching based on service history and reviews.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-line-chart text-xl text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Predictive Analytics</h4>
                            <p class="text-sm text-muted">Maintenance payment forecasting, vendor performance scoring, and community engagement insights.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=ai" class="btn-outline px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2 hover:bg-white hover:text-black hover:border-white transition-all">
                    Estimate AI Integration <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="glass-panel rounded-3xl p-2 relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/20 to-transparent opacity-50 rounded-3xl blur-xl"></div>
                    <div class="bg-[#0a0a0a] border border-white/10 rounded-2xl h-[400px] flex flex-col overflow-hidden relative z-10 p-6">
                        <div class="text-xs text-muted uppercase tracking-wider mb-4">AI Assistant — Support Desk</div>
                        <div class="space-y-4 flex-grow">
                            <div class="bg-white/5 rounded-xl p-4 max-w-[85%]">
                                <p class="text-sm text-muted">"What's the process for NOC approval in our society?"</p>
                            </div>
                            <div class="bg-accent/10 border border-accent/20 rounded-xl p-4 max-w-[85%] ml-auto">
                                <p class="text-sm text-muted">Based on your internal policy document (Section 4.2), this request requires verification and approval. I can generate the checklist, route it to the right team, and draft the response. <span class="text-accent-light">Create workflow →</span></p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 max-w-[85%]">
                                <p class="text-sm text-muted">"Show me unpaid maintenance for Block B"</p>
                            </div>
                        </div>
                        <div class="h-10 rounded-lg bg-white/5 border border-white/10 flex items-center px-4 mt-4">
                            <span class="text-xs text-muted">Ask anything about your society...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Custom Software -->
    <section id="custom" class="scroll-mt-32 relative">
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-primary/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-primary/20 bg-primary/5 text-primary-light text-xs font-bold tracking-widest uppercase mb-8">
                    <i class='bx bx-cube-alt'></i> Custom Software
                </div>
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Domain-Specific Platforms</h2>
                <p class="text-muted mb-8 leading-relaxed font-light text-lg">
                    We build custom SaaS and domain platforms — from scratch — for industries with unique workflows. We replicate this approach for property management, healthcare scheduling, logistics, education, and any domain where generic software doesn't fit.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-buildings text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Product-grade architecture</h4>
                            <p class="text-sm text-muted">Robust data models, modular services, clean UX patterns, and predictable delivery milestones.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-palette text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">White-Label & Theming</h4>
                            <p class="text-sm text-muted">Per-tenant theme engines with preset libraries, CSS generation APIs, and admin-level customization controls.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-cog text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Super-Admin Consoles</h4>
                            <p class="text-sm text-muted">Organization onboarding, earnings dashboards, menu configuration, and platform-wide management tools.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=custom" class="btn-outline px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2 hover:bg-white hover:text-black hover:border-white transition-all">
                    Estimate Custom Platform <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="glass-panel rounded-3xl p-8">
                    <h4 class="text-lg font-bold mb-6 font-['Outfit']">What we commonly deliver</h4>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <i class='bx bx-bell text-primary mb-2'></i>
                            <div class="text-xs font-bold text-foreground">Announcements</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <i class='bx bx-receipt gradient-text-accent mb-2'></i>
                            <div class="text-xs font-bold text-foreground">Maintenance</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <i class='bx bx-support text-primary-light mb-2'></i>
                            <div class="text-xs font-bold text-foreground">Helpdesk</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <i class='bx bx-group gradient-text-accent mb-2'></i>
                            <div class="text-xs font-bold text-foreground">Community</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <i class='bx bx-store-alt text-primary-light mb-2'></i>
                            <div class="text-xs font-bold text-foreground">Vendors</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <i class='bx bx-check-shield text-primary-light mb-2'></i>
                            <div class="text-xs font-bold text-foreground">SOLID Approvals</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <i class='bx bx-calendar-event gradient-text-accent mb-2'></i>
                            <div class="text-xs font-bold text-foreground">Events</div>
                        </div>
                        <div class="p-3 rounded-xl bg-white/5 border border-white/10">
                            <i class='bx bx-palette text-primary-light mb-2'></i>
                            <div class="text-xs font-bold text-foreground">Theme Engine</div>
                        </div>
                    </div>
                    <p class="text-xs text-muted mt-6 text-center">Every module is organization-scoped, role-protected, and API-ready.</p>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Global CTA -->
<section class="py-24 border-t border-white/5 bg-background">
    <div class="max-w-4xl mx-auto text-center px-6" data-aos="zoom-in">
        <h2 class="text-3xl font-black mb-6 font-['Outfit']">Have a platform idea?</h2>
        <p class="text-muted mb-8">Tell us what you’re building — a web app, mobile product, AI feature, or a full custom platform — and we’ll propose a delivery plan.</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('businzo.estimate') }}" class="btn-premium px-8 py-3 rounded-full font-bold inline-flex items-center justify-center gap-2">
                <i class='bx bx-calculator'></i> Get an Estimate
            </a>
            <a href="{{ route('businzo.contact') }}" class="btn-outline px-8 py-3 rounded-full font-bold inline-flex items-center justify-center">
                Book a Consultation
            </a>
        </div>
    </div>
</section>
@endsection
