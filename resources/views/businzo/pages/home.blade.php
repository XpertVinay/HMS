@extends('businzo.layouts.app')

@section('title', 'Businzo | Web, Mobile & AI Software Engineering')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center pt-10 overflow-hidden">
        <!-- Abstract Glows -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <div
                class="absolute top-1/4 right-0 w-[800px] h-[800px] bg-primary/20 rounded-full blur-[120px] mix-blend-screen opacity-60">
            </div>
            <div
                class="absolute bottom-0 left-1/4 w-[600px] h-[600px] bg-accent/10 rounded-full blur-[100px] mix-blend-screen opacity-60">
            </div>
            <!-- Grid Pattern overlay -->
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                <div class="text-left space-y-8 max-w-2xl">

                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-white/10 bg-white/5 backdrop-blur-md"
                        data-aos="fade-right">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-xs font-bold tracking-widest text-muted uppercase">IT Services • Web • Mobile •
                            AI/ML</span>
                    </div>

                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-[1.1] tracking-tight"
                        data-aos="fade-right" data-aos-delay="100">
                        Build modern <br>
                        <span class="gradient-text-accent">software products.</span>
                    </h1>

                    <p class="text-lg md:text-xl text-muted leading-relaxed font-light" data-aos="fade-right"
                        data-aos-delay="200">
                        Businzo Technologies develops secure, scalable web, mobile, and AI solutions that accelerate business growth. From MVPs to enterprise platforms, we deliver custom software, AI agents, MCP integrations, and intelligent automation. Transform ideas into production-ready products with robust architecture, enterprise-grade security, seamless deployment, and future-ready innovation.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('businzo.estimate') }}"
                            class="btn-premium px-8 py-4 rounded-full text-center flex items-center justify-center gap-2 font-bold group w-full sm:w-auto">
                            Start Your Project
                            <i class='bx bx-right-arrow-alt text-xl group-hover:translate-x-1 transition-transform'></i>
                        </a>
                        <a href="{{ route('businzo.services') }}"
                            class="btn-outline px-8 py-4 rounded-full text-center flex items-center justify-center font-bold w-full sm:w-auto">
                            Explore Expertise
                        </a>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="400"
                        class="flex flex-wrap items-center gap-x-6 gap-y-3 pt-10 border-t border-white/10 text-sm font-medium text-muted">
                        <div class="flex items-center gap-2"><i class='bx bx-check-circle text-muted'></i> Product
                            Strategy</div>
                        <div class="flex items-center gap-2"><i class='bx bx-check-circle text-muted'></i> Clean
                            Architecture</div>
                        <div class="flex items-center gap-2"><i class='bx bx-check-circle text-muted'></i> Secure
                            Delivery</div>
                    </div>
                </div>

                <div class="relative lg:block hidden" data-aos="zoom-in-up" data-aos-duration="1000">
                    <div
                        class="relative w-full rounded-2xl overflow-hidden shadow-2xl shadow-primary/20 transform transition-all hover:scale-[1.02] duration-500 border border-white/10">
                        <img src="{{ asset('assets/images/businzo/hero.png') }}"
                            alt="Businzo product engineering — modern dashboards and platforms"
                            class="w-full h-auto object-cover opacity-90 hover:opacity-100 transition-opacity">
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-accent/10 mix-blend-overlay">
                        </div>
                    </div>

                    <div class="absolute -bottom-8 -left-8 glass-panel p-6 rounded-2xl animate-[bounce_5s_infinite]">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary-light">
                                <i class='bx bx-rocket text-2xl'></i>
                            </div>
                            <div>
                                <div class="text-xs text-muted font-bold uppercase tracking-wider mb-1">Delivery</div>
                                <div class="text-2xl font-black text-foreground">MVP → Scale</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack -->
    <section class="py-20 border-y border-white/5 bg-elevated relative overflow-hidden" id="tech-stack-section">
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)] opacity-40 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12" data-aos="fade-up">
                <p class="text-sm font-bold tracking-widest gradient-text-accent uppercase mb-4">Technology Stack</p>
                <h2 class="text-3xl md:text-4xl font-black font-['Outfit'] mb-4">Built with production-proven technologies</h2>
                <p class="text-muted text-sm md:text-base max-w-2xl mx-auto">Browse by discipline — select a category to explore the languages, tools, and frameworks we use in production.</p>
            </div>

            @php
                $techCategories = [
                    [
                        'id' => 'web',
                        'title' => 'Web App',
                        'icon' => 'bx-globe',
                        'accent' => 'text-primary',
                        'glow' => 'glow-primary',
                        'items' => [
                            ['icon' => 'bxl-php', 'label' => 'PHP', 'detail' => 'Laravel · CodeIgniter · Yii'],
                            ['icon' => 'bxl-java', 'label' => 'Java', 'detail' => 'Spring Boot · JSP/Servlet'],
                            ['icon' => 'bxl-python', 'label' => 'Python', 'detail' => 'Django · Flask · FastAPI'],
                            ['icon' => 'bxl-nodejs', 'label' => 'Node.js', 'detail' => 'Express · NestJS · MERN'],
                            ['icon' => 'bxl-react', 'label' => 'React', 'detail' => 'SPA · SSR · Next.js'],
                            ['icon' => 'bxl-angular', 'label' => 'Angular', 'detail' => 'Enterprise SPA'],
                            ['icon' => 'bxl-vuejs', 'label' => 'Vue.js', 'detail' => 'Nuxt · Composition API'],
                            ['icon' => 'bx-code-block', 'label' => 'TypeScript', 'detail' => 'Type-safe frontends & APIs'],
                        ],
                    ],
                    [
                        'id' => 'mobile',
                        'title' => 'Mobile App',
                        'icon' => 'bx-mobile-alt',
                        'accent' => 'text-accent',
                        'glow' => 'glow-accent',
                        'items' => [
                            ['icon' => 'bxl-android', 'label' => 'Android', 'detail' => 'Kotlin · Java'],
                            ['icon' => 'bxl-apple', 'label' => 'iOS', 'detail' => 'Swift · SwiftUI'],
                            ['icon' => 'bxl-react', 'label' => 'React Native', 'detail' => 'Cross-platform apps'],
                            ['icon' => 'bx-mobile', 'label' => 'Flutter', 'detail' => 'Dart · Material & Cupertino'],
                            ['icon' => 'bx-lock-alt', 'label' => 'Secure APIs', 'detail' => 'JWT · OAuth · Keychain'],
                            ['icon' => 'bx-wifi-off', 'label' => 'Offline UX', 'detail' => 'Local cache · sync queues'],
                        ],
                    ],
                    [
                        'id' => 'devops',
                        'title' => 'DevOps',
                        'icon' => 'bx-server',
                        'accent' => 'text-primary-light',
                        'glow' => 'glow-primary',
                        'items' => [
                            ['icon' => 'bxl-docker', 'label' => 'Docker', 'detail' => 'Containerized services'],
                            ['icon' => 'bx-cube', 'label' => 'Kubernetes', 'detail' => 'Orchestration & scaling'],
                            ['icon' => 'bx-git-branch', 'label' => 'CI/CD', 'detail' => 'GitHub Actions · GitLab CI'],
                            ['icon' => 'bx-cloud', 'label' => 'Cloud', 'detail' => 'AWS · GCP · Azure'],
                            ['icon' => 'bx-shield-quarter', 'label' => 'Nginx', 'detail' => 'Reverse proxy · TLS'],
                            ['icon' => 'bx-line-chart', 'label' => 'Monitoring', 'detail' => 'Logs · alerts · uptime'],
                        ],
                    ],
                    [
                        'id' => 'database',
                        'title' => 'Database',
                        'icon' => 'bx-data',
                        'accent' => 'text-primary-light',
                        'glow' => 'glow-primary',
                        'items' => [
                            ['icon' => 'bx-data', 'label' => 'MySQL', 'detail' => 'Relational · transactions'],
                            ['icon' => 'bx-data', 'label' => 'PostgreSQL', 'detail' => 'Advanced SQL · JSONB'],
                            ['icon' => 'bxl-mongodb', 'label' => 'MongoDB', 'detail' => 'Document store'],
                            ['icon' => 'bxl-redis', 'label' => 'Redis', 'detail' => 'Cache · sessions · queues'],
                            ['icon' => 'bx-search-alt', 'label' => 'Elasticsearch', 'detail' => 'Search & analytics'],
                            ['icon' => 'bx-transfer', 'label' => 'Migrations', 'detail' => 'Schema versioning · rollbacks'],
                        ],
                    ],
                    [
                        'id' => 'api',
                        'title' => 'RESTful / GraphQL',
                        'icon' => 'bx-git-merge',
                        'accent' => 'text-accent-light',
                        'glow' => 'glow-accent',
                        'items' => [
                            ['icon' => 'bx-transfer-alt', 'label' => 'REST API', 'detail' => 'Resource-oriented endpoints'],
                            ['icon' => 'bx-network-chart', 'label' => 'GraphQL', 'detail' => 'Apollo · flexible queries'],
                            ['icon' => 'bx-file', 'label' => 'OpenAPI', 'detail' => 'Swagger · contract-first design'],
                            ['icon' => 'bx-plug', 'label' => 'gRPC', 'detail' => 'High-performance microservices'],
                            ['icon' => 'bx-key', 'label' => 'Auth', 'detail' => 'JWT · OAuth 2.0 · RBAC'],
                            ['icon' => 'bx-broadcast', 'label' => 'WebSockets', 'detail' => 'Real-time events & feeds'],
                        ],
                    ],
                    [
                        'id' => 'ai',
                        'title' => 'AI/ML Engineering',
                        'icon' => 'bx-brain',
                        'accent' => 'text-accent',
                        'glow' => 'glow-accent',
                        'items' => [
                            ['icon' => 'bx-chip', 'label' => 'Transformers', 'detail' => 'Hugging Face · fine-tuning'],
                            ['icon' => 'bx-brain', 'label' => 'NLP', 'detail' => 'BERT · embeddings · classification'],
                            ['icon' => 'bx-bot', 'label' => 'AI Agents', 'detail' => 'Autonomous workflows'],
                            ['icon' => 'bx-book-open', 'label' => 'RAG', 'detail' => 'Document Q&A over private data'],
                            ['icon' => 'bx-network-chart', 'label' => 'MCP', 'detail' => 'Model Context Protocol'],
                            ['icon' => 'bx-sparkles', 'label' => 'GenAI', 'detail' => 'LLM apps · OpenAI · Claude'],
                        ],
                    ],
                ];
            @endphp

            <div data-aos="fade-up" data-aos-delay="100">
                {{-- Horizontally scrollable category tabs --}}
                <div class="relative mb-6">
                    <div class="pointer-events-none absolute inset-y-0 left-0 w-8 bg-gradient-to-r from-elevated to-transparent z-10"></div>
                    <div class="pointer-events-none absolute inset-y-0 right-0 w-8 bg-gradient-to-l from-elevated to-transparent z-10"></div>
                    <div id="tech-category-scroll" class="tech-category-scroll flex gap-3 overflow-x-auto pb-2 -mx-1 px-1 scroll-smooth">
                        @foreach ($techCategories as $index => $category)
                            <button type="button"
                                class="tech-category-btn shrink-0 flex items-center gap-2.5 px-5 py-3 rounded-2xl border transition-all duration-200 {{ $index === 0 ? 'is-active border-primary/40 bg-primary/10 text-foreground' : 'border-white/10 bg-white/[0.02] text-muted hover:bg-white/[0.05] hover:border-white/20 hover:text-foreground' }}"
                                data-tech-category="{{ $category['id'] }}"
                                aria-expanded="{{ 'false' }}"
                                aria-controls="tech-panel-{{ $category['id'] }}">
                                <span class="w-9 h-9 rounded-xl {{ $category['glow'] }} border border-white/10 flex items-center justify-center">
                                    <i class='bx {{ $category['icon'] }} text-lg {{ $category['accent'] }}'></i>
                                </span>
                                <span class="text-sm font-bold font-['Outfit'] whitespace-nowrap">{{ $category['title'] }}</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-subtle whitespace-nowrap">{{ count($category['items']) }} tools</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Full-width expandable technology panel --}}
                <div id="tech-stack-panel" class="w-full glass-panel rounded-3xl overflow-hidden">
                    @foreach ($techCategories as $index => $category)
                        <div id="tech-panel-{{ $category['id'] }}"
                            class="tech-panel {{ $index === 0 ? '' : 'hidden' }}"
                            role="region"
                            aria-label="{{ $category['title'] }} technologies">
                            <div class="p-6 md:p-8 border-b border-white/5 flex items-center gap-3">
                                <div class="w-11 h-11 rounded-xl {{ $category['glow'] }} border border-white/10 flex items-center justify-center">
                                    <i class='bx {{ $category['icon'] }} text-xl {{ $category['accent'] }}'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-foreground font-['Outfit']">{{ $category['title'] }}</h3>
                                    <p class="text-xs text-muted">{{ count($category['items']) }} technologies in this stack</p>
                                </div>
                            </div>
                            <div class="p-6 md:p-8">
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($category['items'] as $tech)
                                        <div class="group flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/[0.03] border border-white/10 hover:bg-white/[0.06] hover:border-white/20 transition-all">
                                            <div class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                                <i class='bx {{ $tech['icon'] }} text-lg text-muted group-hover:text-foreground transition-colors'></i>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-sm font-bold text-foreground leading-tight">{{ $tech['label'] }}</div>
                                                <div class="text-[11px] text-subtle leading-snug">{{ $tech['detail'] }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Highlight -->
    <section class="py-32 relative z-10 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div data-aos="fade-right">
                    <h2 class="text-sm font-bold tracking-widest gradient-text-accent uppercase mb-4">Portfolio Highlight</h2>
                    <h3 class="text-4xl md:text-5xl font-black mb-6">Case studies that <br><span class="text-muted">prove
                            delivery.</span></h3>
                    <p class="text-muted leading-relaxed mb-8 text-lg font-light">
                        Explore our case studies to see how we handle architecture, security, and modular delivery for
                        real-world operations — across web apps, mobile products, AI features, and custom platforms.
                    </p>
                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="glass-panel p-4 rounded-xl">
                            <i class='bx bx-user-check text-2xl text-primary mb-2'></i>
                            <div class="text-sm font-bold text-foreground">Role-based systems</div>
                            <div class="text-xs text-muted mt-1">Portals, permissions, audit-ready flows</div>
                        </div>
                        <div class="glass-panel p-4 rounded-xl">
                            <i class='bx bx-palette text-2xl gradient-text-accent mb-2'></i>
                            <div class="text-sm font-bold text-foreground">Design systems</div>
                            <div class="text-xs text-muted mt-1">Premium UI patterns & consistency</div>
                        </div>
                        <div class="glass-panel p-4 rounded-xl">
                            <i class='bx bx-receipt text-2xl text-primary-light mb-2'></i>
                            <div class="text-sm font-bold text-foreground">Business workflows</div>
                            <div class="text-xs text-muted mt-1">Billing, approvals, automation</div>
                        </div>
                        <div class="glass-panel p-4 rounded-xl">
                            <i class='bx bx-store-alt text-2xl gradient-text-accent mb-2'></i>
                            <div class="text-sm font-bold text-foreground">Platform ecosystems</div>
                            <div class="text-xs text-muted mt-1">Marketplaces, listings, payments</div>
                        </div>
                    </div>
                    <a href="{{ route('businzo.portfolio') }}"
                        class="text-foreground font-semibold flex items-center gap-2 hover:text-primary transition-colors">
                        View portfolio <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
                <div data-aos="fade-left">
                    <div class="glass-panel p-8 rounded-3xl">
                        <h4 class="text-lg font-bold mb-6 font-['Outfit']">How we engineer</h4>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <i class='bx bx-check-circle text-primary text-xl mt-0.5'></i>
                                <div>
                                    <span class="text-foreground font-semibold">Architecture-first</span>
                                    <p class="text-sm text-muted">Clear boundaries, scalable APIs, and robust data
                                        modeling for growth.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class='bx bx-check-circle text-primary text-xl mt-0.5'></i>
                                <div>
                                    <span class="text-foreground font-semibold">Security by default</span>
                                    <p class="text-sm text-muted">Role-based access, safe auth patterns, and deployment
                                        hygiene.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class='bx bx-check-circle text-primary text-xl mt-0.5'></i>
                                <div>
                                    <span class="text-foreground font-semibold">Automated quality gates</span>
                                    <p class="text-sm text-muted">Static analysis, tests, and CI checks before releases.
                                    </p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class='bx bx-check-circle text-primary text-xl mt-0.5'></i>
                                <div>
                                    <span class="text-foreground font-semibold">End-to-end delivery</span>
                                    <p class="text-sm text-muted">From discovery to deploy: web, mobile, AI/ML, and
                                        custom integrations.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Box Services Section -->
    <section class="py-32 relative z-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="max-w-3xl mb-20" data-aos="fade-up">
                <h2 class="text-sm font-bold tracking-widest gradient-text-accent uppercase mb-4">What We Build</h2>
                <h3 class="text-4xl md:text-5xl font-black mb-6">End-to-end engineering for <br><span
                        class="text-muted">web, mobile & AI.</span></h3>
                <p class="text-muted text-lg font-light">From startups to enterprise teams — we handle architecture,
                    development, deployment, and ongoing iteration.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Bento Box 1: Web (Large) -->
                <div class="md:col-span-2 glass-panel p-8 md:p-12 rounded-3xl group relative overflow-hidden transition-all hover:bg-white/[0.02]"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-primary/10 blur-[80px] rounded-full group-hover:bg-primary/20 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <i class='bx bx-layer text-4xl text-primary mb-6'></i>
                        <h4 class="text-2xl font-bold mb-4">Enterprise Web Platforms</h4>
                        <p class="text-muted mb-8 max-w-mx leading-relaxed">
                            <strong>Enterprise-grade software platforms engineered for scale, security, and
                                reliability.</strong> We build multi-role ecosystems, operational dashboards, transaction
                            engines, and partner marketplaces with modern architectures, automated delivery pipelines, and
                            resilient infrastructure—ensuring high performance, strict data isolation, seamless scalability,
                            and long-term maintainability.
                        </p>
                        <a href="{{ route('businzo.services') }}#web"
                            class="text-foreground font-semibold flex items-center gap-2 hover:text-primary transition-colors">
                            Web Architecture Details <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>

                <!-- Bento Box 2: Mobile -->
                <div class="glass-panel p-8 md:p-12 rounded-3xl group relative overflow-hidden transition-all hover:bg-white/[0.02]"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-accent/10 blur-[50px] rounded-full group-hover:bg-accent/20 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <i class='bx bx-mobile text-4xl gradient-text-accent mb-6'></i>
                        <h4 class="text-2xl font-bold mb-4">Mobile Apps</h4>
                        <p class="text-muted mb-8 leading-relaxed">
                            Native iOS & Android apps backed by JWT-secured REST APIs. Residents pay bills, raise tickets,
                            and browse community feeds from their phones.
                        </p>
                        <a href="{{ route('businzo.services') }}#mobile"
                            class="text-foreground font-semibold flex items-center gap-2 hover:text-accent transition-colors">
                            Mobile Engineering <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>

                <!-- Bento Box 3: AI -->
                <div class="glass-panel p-8 md:p-12 rounded-3xl group relative overflow-hidden transition-all hover:bg-white/[0.02]"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="absolute bottom-0 left-0 w-48 h-48 bg-primary/10 blur-[60px] rounded-full group-hover:bg-primary/20 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <i class='bx bx-brain text-4xl gradient-text-accent mb-6'></i>
                        <h4 class="text-2xl font-bold mb-4">AI & Automation</h4>
                        <p class="text-muted mb-8 leading-relaxed">
                            Smart ticket routing, document Q&A over society records, predictive maintenance alerts, and
                            autonomous approval assistants.
                        </p>
                        <a href="{{ route('businzo.services') }}#ai"
                            class="text-foreground font-semibold flex items-center gap-2 hover:text-accent transition-colors">
                            AI Integration <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>

                <!-- Bento Box 4: Custom Software (Large) -->
                <div class="md:col-span-2 glass-panel p-8 md:p-12 rounded-3xl group relative overflow-hidden transition-all hover:bg-white/[0.02]"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="absolute top-1/2 right-10 w-[200px] h-[200px] border border-white/5 rounded-full flex items-center justify-center -translate-y-1/2">
                        <div
                            class="w-[150px] h-[150px] border border-white/5 rounded-full flex items-center justify-center">
                            <i class='bx bx-code-block text-6xl text-white/10'></i>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <i class='bx bx-cube-alt text-4xl text-primary mb-6'></i>
                        <h4 class="text-2xl font-bold mb-4">Custom SaaS & Domain Platforms</h4>
                        <p class="text-muted mb-8 max-w-md leading-relaxed">
                            When off-the-shelf won't work. We build industry-specific platforms — property management,
                            vendor ecosystems, approval workflows, and super-admin consoles — from discovery to production
                            deployment.
                        </p>
                        <a href="{{ route('businzo.services') }}#custom"
                            class="text-foreground font-semibold flex items-center gap-2 hover:text-primary-light transition-colors">
                            Custom Engineering <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="py-24 border-y border-white/5 bg-elevated relative overflow-hidden">
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-primary/5 rounded-full blur-[120px] pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-14" data-aos="fade-up">
                <p class="text-sm font-bold tracking-widest gradient-text-accent uppercase mb-4">Delivery Process</p>
                <h2 class="text-3xl md:text-4xl font-black font-['Outfit'] mb-4">How we deliver software</h2>
                <p class="text-muted max-w-3xl mx-auto">A proven end-to-end lifecycle — from first conversation to
                    production launch and long-term evolution. Transparent milestones at every stage.</p>
            </div>

            @php
                $deliverySteps = [
                    ['step' => '01', 'icon' => 'bx-search-alt', 'title' => 'Discovery & Scoping', 'description' => 'We align on business goals, users, constraints, and success metrics. Workshops, requirement analysis, and feasibility assessment.', 'tags' => ['Stakeholder interviews', 'Requirements doc', 'Feasibility study']],
                    ['step' => '02', 'icon' => 'bx-layer', 'title' => 'Architecture & Planning', 'description' => 'Technical blueprint, stack selection, data models, API contracts, sprint roadmap, and a clear statement of work.', 'tags' => ['System design', 'Tech stack', 'Project roadmap']],
                    ['step' => '03', 'icon' => 'bx-palette', 'title' => 'UX / UI Design', 'description' => 'Wireframes, interactive prototypes, and a cohesive design system — validated before a single line of production code.', 'tags' => ['Wireframes', 'Prototypes', 'Design system']],
                    ['step' => '04', 'icon' => 'bx-code-block', 'title' => 'Agile Development', 'description' => 'Two-week sprints with demos, code reviews, and incremental delivery. Web, mobile, APIs, and third-party integrations built in parallel.', 'tags' => ['Sprint demos', 'Code reviews', 'API development']],
                    ['step' => '05', 'icon' => 'bx-check-shield', 'title' => 'QA & Security Testing', 'description' => 'Automated unit and integration tests, UAT cycles, performance checks, and security hardening before release.', 'tags' => ['Automated tests', 'UAT', 'Security audit']],
                    ['step' => '06', 'icon' => 'bxl-docker', 'title' => 'DevOps & Deployment', 'description' => 'CI/CD pipelines, staging environments, containerized releases, monitoring, and zero-downtime production deploys.', 'tags' => ['CI/CD pipeline', 'Docker / K8s', 'Monitoring']],
                    ['step' => '07', 'icon' => 'bx-rocket', 'title' => 'Launch & Handover', 'description' => 'Go-live support, technical documentation, admin training, and a clean handover so your team owns the product confidently.', 'tags' => ['Go-live support', 'Documentation', 'Team training']],
                    ['step' => '08', 'icon' => 'bx-refresh', 'title' => 'Support & Evolution', 'description' => 'Ongoing maintenance, bug fixes, feature iterations, performance tuning, and scaling as your user base grows.', 'tags' => ['Maintenance', 'New features', 'Scale & optimize']],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" data-aos="fade-up" data-aos-delay="100">
                @foreach ($deliverySteps as $index => $phase)
                    @php
                        $phaseColor = $index % 2 === 0 ? 'text-primary' : 'gradient-text-accent';
                        $phaseGlow = $index % 2 === 0 ? 'glow-primary' : 'glow-accent';
                    @endphp
                    <div class="glass-panel rounded-3xl p-6 hover:bg-white/[0.02] transition-colors group relative"
                        data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 50 }}">
                        <div class="flex items-start justify-between mb-5">
                            <div class="w-11 h-11 rounded-xl {{ $phaseGlow }} border border-white/10 flex items-center justify-center group-hover:scale-105 transition-transform">
                                <i class='bx {{ $phase['icon'] }} text-xl {{ $phaseColor }}'></i>
                            </div>
                            <span class="text-xs font-black {{ $phaseColor }} opacity-60">{{ $phase['step'] }}</span>
                        </div>
                        <h4 class="font-bold text-foreground font-['Outfit'] mb-2 text-sm">{{ $phase['title'] }}</h4>
                        <p class="text-xs text-muted leading-relaxed mb-4">{{ $phase['description'] }}</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($phase['tags'] as $tag)
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-white/5 border border-white/10 text-subtle font-medium">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 glass-panel rounded-2xl p-5 md:p-6 flex flex-col md:flex-row items-center justify-between gap-4"
                data-aos="fade-up" data-aos-delay="200">
                <div class="flex items-center gap-4 text-center md:text-left">
                    <div
                        class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                        <i class='bx bx-time-five text-2xl text-muted'></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-foreground">Typical timeline</p>
                        <p class="text-xs text-muted">MVP in 6–10 weeks · Full platform in 3–6 months · Enterprise in
                            6–12+ months</p>
                    </div>
                </div>
                <a href="{{ route('businzo.contact') }}"
                    class="btn-outline px-6 py-2.5 rounded-full text-sm font-bold whitespace-nowrap hover:bg-white hover:text-black hover:border-white transition-all">
                    Discuss your project <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 relative overflow-hidden border-t border-white/5">
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] [mask-image:radial-gradient(ellipse_at_center,black,transparent_70%)] opacity-50 z-0">
        </div>

        <div class="max-w-4xl mx-auto px-6 lg:px-8 relative z-10 text-center" data-aos="zoom-in" data-aos-duration="1000">
            <h2 class="text-4xl md:text-6xl font-black mb-8 tracking-tight">Ready to build your <br><span
                    class="text-muted">next platform?</span></h2>
            <p class="text-muted text-lg mb-8 max-w-2xl mx-auto">Whether you need a web application, mobile app, AI/ML
                integration, or a full custom platform — let's scope it together.</p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-12">
                <a href="{{ route('businzo.estimate') }}"
                    class="btn-premium px-10 py-4 rounded-full font-bold text-lg inline-flex items-center justify-center gap-2">
                    <i class='bx bx-calculator text-2xl'></i> Get an Estimate
                </a>
                <a href="{{ route('businzo.contact') }}"
                    class="btn-outline px-10 py-4 rounded-full font-bold text-lg inline-flex items-center justify-center">
                    Talk to Our Team
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .tech-category-scroll {
        scrollbar-width: none;
        -ms-overflow-style: none;
        -webkit-overflow-scrolling: touch;
    }
    .tech-category-scroll::-webkit-scrollbar {
        display: none;
    }
    .tech-category-btn.is-active {
        border-color: rgba(27, 68, 155, 0.4);
        background: rgba(27, 68, 155, 0.1);
        color: var(--text-foreground);
        box-shadow: 0 4px 20px rgba(27, 68, 155, 0.15);
    }
    .tech-panel {
        animation: techPanelIn 0.25s ease-out;
    }
    @keyframes techPanelIn {
        from { opacity: 0; transform: translateY(6px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.tech-category-btn');
        const panels = document.querySelectorAll('.tech-panel');
        const scrollContainer = document.getElementById('tech-category-scroll');

        if (!buttons.length || !panels.length) return;

        function setActiveCategory(categoryId) {
            buttons.forEach((btn) => {
                const isActive = btn.dataset.techCategory === categoryId;
                btn.classList.toggle('is-active', isActive);
                btn.classList.toggle('border-primary/40', isActive);
                btn.classList.toggle('bg-primary/10', isActive);
                btn.classList.toggle('text-foreground', isActive);
                btn.classList.toggle('border-white/10', !isActive);
                btn.classList.toggle('bg-white/[0.02]', !isActive);
                btn.classList.toggle('text-muted', !isActive);
                btn.setAttribute('aria-expanded', isActive ? 'true' : 'false');
            });

            panels.forEach((panel) => {
                const isVisible = panel.id === 'tech-panel-' + categoryId;
                panel.classList.toggle('hidden', !isVisible);
            });
        }

        buttons.forEach((btn) => {
            btn.addEventListener('click', function () {
                const categoryId = this.dataset.techCategory;
                setActiveCategory(categoryId);

                const panel = document.getElementById('tech-panel-' + categoryId);
                if (panel) {
                    panel.style.animation = 'none';
                    panel.offsetHeight;
                    panel.style.animation = '';
                }

                this.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            });
        });

        if (scrollContainer) {
            scrollContainer.addEventListener('wheel', function (event) {
                if (Math.abs(event.deltaY) > Math.abs(event.deltaX)) {
                    event.preventDefault();
                    scrollContainer.scrollLeft += event.deltaY;
                }
            }, { passive: false });
        }
    });
</script>
@endpush