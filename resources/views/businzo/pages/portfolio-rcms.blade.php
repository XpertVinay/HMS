@extends('businzo.layouts.app')

@section('title', 'Case Study — Residential Community Management System')

@section('content')
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)] z-0"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10" data-aos="fade-up">
        <a href="{{ route('businzo.portfolio') }}" class="inline-flex items-center gap-2 text-muted hover:text-foreground transition-colors mb-6">
            <i class='bx bx-left-arrow-alt text-xl'></i> Back to Portfolio
        </a>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-white/10 bg-white/5 backdrop-blur-md mb-6">
            <i class='bx bx-buildings text-primary'></i>
            <span class="text-xs font-bold tracking-widest text-muted uppercase">Case Study</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-6">Residential Community <span class="text-subtle">Management System</span></h1>
        <p class="text-xl text-muted max-w-3xl font-light">A full-stack platform for residential societies — built as a multi-role, scalable web application with mobile-ready APIs and extensible modules.</p>
    </div>
</div>

<section class="py-24 relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-16" data-aos="fade-up" data-aos-delay="100">
            <div class="glass-panel p-8 rounded-3xl">
                <div class="text-xs text-muted uppercase tracking-wider font-bold mb-2">Scope</div>
                <div class="text-foreground font-semibold">Web Platform + Admin Portals</div>
                <p class="text-muted text-sm mt-3">Role-based dashboards and operational workflows.</p>
            </div>
            <div class="glass-panel p-8 rounded-3xl">
                <div class="text-xs text-muted uppercase tracking-wider font-bold mb-2">Integrations</div>
                <div class="text-foreground font-semibold">APIs + Queue Workflows</div>
                <p class="text-muted text-sm mt-3">Background processing with scalable infrastructure patterns.</p>
            </div>
            <div class="glass-panel p-8 rounded-3xl">
                <div class="text-xs text-muted uppercase tracking-wider font-bold mb-2">Outcome</div>
                <div class="text-foreground font-semibold">Modular, extensible product</div>
                <p class="text-muted text-sm mt-3">Built to evolve: new modules, portals, and tenants.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <div class="space-y-10" data-aos="fade-right">
                <div>
                    <h2 class="text-3xl font-black font-['Outfit'] mb-4">Problem</h2>
                    <p class="text-muted leading-relaxed">Residential communities rely on fragmented tools for billing, complaints, announcements, and vendor coordination. The goal was to unify these workflows into one secure, role-based platform.</p>
                </div>

                <div>
                    <h2 class="text-3xl font-black font-['Outfit'] mb-4">Solution</h2>
                    <p class="text-muted leading-relaxed mb-6">A modular web application with clearly separated portals and extensible features, designed to support multiple communities and evolving operational needs.</p>
                    <ul class="space-y-3 text-muted">
                        <li class="flex items-start gap-3"><i class='bx bx-check-circle text-primary text-xl mt-0.5'></i> Admin, staff, member, resident, vendor, and super-admin experiences</li>
                        <li class="flex items-start gap-3"><i class='bx bx-check-circle text-primary text-xl mt-0.5'></i> Maintenance billing, ticketing/helpdesk, announcements, community feed</li>
                        <li class="flex items-start gap-3"><i class='bx bx-check-circle text-primary text-xl mt-0.5'></i> Vendor directory, reviews, voting, and service workflows</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-3xl font-black font-['Outfit'] mb-4">Technology</h2>
                    <p class="text-muted leading-relaxed">Built with a modern Laravel stack, containerized infrastructure, and a frontend pipeline designed for fast iteration.</p>
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="glass-panel p-4 rounded-2xl"><span class="text-sm font-bold text-foreground">Laravel + PHP</span><div class="text-xs text-muted mt-1">Backend architecture</div></div>
                        <div class="glass-panel p-4 rounded-2xl"><span class="text-sm font-bold text-foreground">MySQL + Redis</span><div class="text-xs text-muted mt-1">Data + queues</div></div>
                        <div class="glass-panel p-4 rounded-2xl"><span class="text-sm font-bold text-foreground">Docker + Nginx</span><div class="text-xs text-muted mt-1">Deployment</div></div>
                        <div class="glass-panel p-4 rounded-2xl"><span class="text-sm font-bold text-foreground">Vite + Tailwind</span><div class="text-xs text-muted mt-1">Frontend pipeline</div></div>
                    </div>
                </div>
            </div>

            <div data-aos="fade-left">
                <div class="glass-panel p-8 rounded-3xl border border-white/10 mb-8">
                    <h3 class="text-xl font-black font-['Outfit'] mb-6">How this translates to your project</h3>
                    <p class="text-muted leading-relaxed mb-8">If you’re building a product with multiple user roles, complex workflows, and future scalability needs, this is the type of engineering discipline we bring to every engagement.</p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i class='bx bx-shield-quarter text-primary text-xl mt-0.5'></i>
                            <div>
                                <div class="text-foreground font-semibold">Security-first design</div>
                                <div class="text-sm text-muted">Role-based access control, scoped data access, and safe deployment practices.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class='bx bx-line-chart text-primary text-xl mt-0.5'></i>
                            <div>
                                <div class="text-foreground font-semibold">Scalable architecture</div>
                                <div class="text-sm text-muted">Queues, caching, and infrastructure patterns that handle growth.</div>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class='bx bx-cog text-primary text-xl mt-0.5'></i>
                            <div>
                                <div class="text-foreground font-semibold">Modular delivery</div>
                                <div class="text-sm text-muted">Ship in phases, with clear milestones and maintainable code.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('businzo.estimate') }}" class="btn-premium px-6 py-3 rounded-full font-bold inline-flex items-center justify-center gap-2">
                            <i class='bx bx-calculator'></i> Get Estimate
                        </a>
                        <a href="{{ route('businzo.contact') }}" class="btn-outline px-6 py-3 rounded-full font-bold inline-flex items-center justify-center">
                            Talk to Us
                        </a>
                    </div>
                </div>
                <div class="glass-panel p-8 rounded-3xl">
                <div class="text-xs text-muted uppercase tracking-wider font-bold mb-2">Live Platform</div>
                <!-- Add live platform URL & Image -->
                <a href="https://businzo.businzo.com" target="_blank" class="text-foreground font-semibold">https://businzo.businzo.com</a>
                <!-- <div class="text-foreground font-semibold">https://rcms.businzo.com</div> -->
                <!-- <p class="text-muted text-sm mt-3">Built to evolve: new modules, portals, and tenants.</p> -->
            </div>
            </div>
            
        </div>
    </div>
</section>
@endsection

