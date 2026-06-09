@extends('businzo.layouts.app')

@section('title', 'Expertise — AI-Powered Software, MCP & Automation')

@section('content')
<!-- Page Header -->
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)] z-0"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10" data-aos="fade-up">
        <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-6 max-w-4xl">AI-powered software <span class="text-subtle">that delivers results.</span></h1>
        <p class="text-xl text-muted max-w-2xl font-light">Outcome-driven engineering — web platforms, mobile products, MCP integrations, and intelligent automation built for security, scalability, and business growth.</p>
        <div class="flex flex-col sm:flex-row gap-4 mt-10">
            <a href="{{ route('businzo.estimate') }}" class="btn-premium px-8 py-3.5 rounded-full font-bold inline-flex items-center justify-center gap-2 w-fit">
                Start Your Project <i class='bx bx-right-arrow-alt'></i>
            </a>
            <a href="{{ route('businzo.contact') }}" class="btn-outline px-8 py-3.5 rounded-full font-bold inline-flex items-center justify-center w-fit">
                Book a Consultation
            </a>
        </div>
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
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Scalable Web Platforms</h2>
                <p class="text-muted mb-8 leading-relaxed font-light text-lg">
                    Ship SaaS products and enterprise portals that grow with your business. We deliver high-performance dashboards, marketplaces, and multi-tenant systems — engineered for uptime, security, and long-term maintainability.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-check text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">API-First, Built to Scale</h4>
                            <p class="text-sm text-muted">Modular architecture and clean APIs that support rapid feature delivery without technical debt.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-check text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Enterprise Security</h4>
                            <p class="text-sm text-muted">RBAC, secure authentication, encryption, and audit trails that protect data as you scale.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-check text-xl text-primary-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Production-Ready from Day One</h4>
                            <p class="text-sm text-muted">CI/CD pipelines, automated testing, containerized deployments — software that ships, not stalls.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=web" class="btn-premium px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2">
                    Start Your Project <i class='bx bx-right-arrow-alt'></i>
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
                                <div class="text-sm font-bold text-white">Your Product</div>
                            </div>
                            <div class="h-24 rounded-xl bg-gradient-to-br from-accent/20 to-primary/20 border border-white/5 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-xs text-muted">Revenue This Month</div>
                                    <div class="text-lg font-black text-white">+24%</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="h-16 rounded-xl bg-white/5 flex flex-col items-center justify-center">
                                    <i class='bx bx-bot gradient-text-accent text-lg'></i>
                                    <span class="text-[10px] text-muted mt-1">AI Agent</span>
                                </div>
                                <div class="h-16 rounded-xl bg-white/5 flex flex-col items-center justify-center">
                                    <i class='bx bx-bell text-primary-light text-lg'></i>
                                    <span class="text-[10px] text-muted mt-1">Alerts</span>
                                </div>
                            </div>
                            <div class="h-10 rounded-xl bg-accent/20 border border-accent/30 flex items-center justify-center text-xs font-bold gradient-text-accent mt-auto">Take Action</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-2 lg:order-2" data-aos="fade-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-accent/20 bg-accent/5 gradient-text-accent text-xs font-bold tracking-widest uppercase mb-8">
                    <i class='bx bx-mobile-alt'></i> Mobile Engineering
                </div>
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Mobile Products That Drive Engagement</h2>
                <p class="text-muted mb-8 leading-relaxed font-light text-lg">
                    Native iOS and Android apps that users love and businesses depend on. Secure backends, offline-ready UX, and push notifications — mobile experiences built to retain users and grow revenue.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bxl-apple text-xl text-white'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">iOS Native (Swift)</h4>
                            <p class="text-sm text-muted">Premium native UI with push notifications, biometric auth, and offline-capable experiences.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bxl-android text-xl gradient-text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Android Native (Kotlin)</h4>
                            <p class="text-sm text-muted">Material Design interfaces with Jetpack Compose, connected to the same JWT API endpoints.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-qr text-xl gradient-text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Secure Mobile + Backend</h4>
                            <p class="text-sm text-muted">JWT/OAuth, robust APIs, telemetry, and scalable backend services.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=mobile" class="btn-premium px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2">
                    Start Your Project <i class='bx bx-right-arrow-alt'></i>
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
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">AI, MCP & Intelligent Automation</h2>
                <p class="text-muted mb-8 leading-relaxed font-light text-lg">
                    Production-grade AI that moves the needle — LLM agents, MCP integrations, RAG pipelines, and workflow automation embedded in your product with enterprise security and privacy controls.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-data text-xl gradient-text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">RAG & Document Intelligence</h4>
                            <p class="text-sm text-muted">Semantic search and Q&A over your private data — answers grounded in your documents, not the public internet.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-bot text-xl gradient-text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">MCP & Agent Integrations</h4>
                            <p class="text-sm text-muted">Connect AI agents to your tools and data via Model Context Protocol — intelligent workflows that act on your systems autonomously.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-line-chart text-xl gradient-text-accent-light'></i>
                        </div>
                        <div>
                            <h4 class="text-foreground font-bold mb-1">Predictive & Decision Intelligence</h4>
                            <p class="text-sm text-muted">Forecasting, classification, and scoring models that turn data into actionable business insights.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=ai" class="btn-premium px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2">
                    Start Your Project <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="glass-panel rounded-3xl p-2 relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent/20 to-transparent opacity-50 rounded-3xl blur-xl"></div>
                    <div class="bg-[#0a0a0a] border border-white/10 rounded-2xl h-[400px] flex flex-col overflow-hidden relative z-10 p-6">
                        <div class="text-xs text-muted uppercase tracking-wider mb-4">AI Agent — MCP Connected</div>
                        <div class="space-y-4 flex-grow">
                            <div class="bg-white/5 rounded-xl p-4 max-w-[85%]">
                                <p class="text-sm text-muted">"Summarize open support tickets and route urgent ones to the right team."</p>
                            </div>
                            <div class="bg-accent/10 border border-accent/20 rounded-xl p-4 max-w-[85%] ml-auto">
                                <p class="text-sm text-muted">Found 12 open tickets — 3 marked urgent. I've classified them, assigned owners via MCP, and drafted responses. <span class="text-accent-light">Execute workflow →</span></p>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4 max-w-[85%]">
                                <p class="text-sm text-muted">"Generate a Q4 revenue forecast from our CRM data."</p>
                            </div>
                        </div>
                        <div class="h-10 rounded-lg bg-white/5 border border-white/10 flex items-center px-4 mt-4">
                            <span class="text-xs text-muted">Ask your AI agent anything...</span>
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
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Custom Software for Your Market</h2>
                <p class="text-muted mb-8 leading-relaxed font-light text-lg">
                    When off-the-shelf tools can't keep up, we build domain-specific platforms from the ground up — tailored workflows, white-label SaaS, and super-admin consoles that give you a competitive edge.
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
                <a href="{{ route('businzo.estimate') }}?type=custom" class="btn-premium px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2">
                    Start Your Project <i class='bx bx-right-arrow-alt'></i>
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
        <h2 class="text-3xl md:text-4xl font-black mb-6 font-['Outfit']">Let's build software that <span class="gradient-text-accent">grows your business.</span></h2>
        <p class="text-muted mb-8 max-w-2xl mx-auto">Share your vision — we'll scope a secure, scalable, AI-ready platform and propose a clear path from idea to production.</p>
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
