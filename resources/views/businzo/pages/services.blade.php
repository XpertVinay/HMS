@extends('businzo.layouts.app')

@section('title', 'Expertise & Architecture')

@section('content')
<!-- Page Header -->
<div class="pt-32 pb-20 relative overflow-hidden bg-background border-b border-white/5">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wMykiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)] z-0"></div>
    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10" data-aos="fade-up">
        <h1 class="text-5xl md:text-7xl font-black font-['Outfit'] tracking-tight mb-6 max-w-4xl">Engineering <span class="text-gray-600">capabilities</span> designed for scale.</h1>
        <p class="text-xl text-gray-400 max-w-2xl font-light">From highly concurrent web systems to intelligent autonomous agents, we build the technology that powers modern businesses.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 lg:px-8 py-24 space-y-40">

    <!-- Web Architecture -->
    <section id="web" class="scroll-mt-32 relative">
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-blue-500/20 bg-blue-500/5 text-blue-400 text-xs font-bold tracking-widest uppercase mb-8">
                    <i class='bx bx-code'></i> Web Architecture
                </div>
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Enterprise Web Systems</h2>
                <p class="text-gray-400 mb-8 leading-relaxed font-light text-lg">
                    We engineer high-performance web applications designed to handle massive traffic and complex business logic. Utilizing modern stacks like Laravel, Next.js, and scalable cloud infrastructure, we deliver platforms that are resilient, secure, and lightning fast.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-check text-xl text-blue-400'></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Microservices & APIs</h4>
                            <p class="text-sm text-gray-500">Decoupled architectures for independent scaling and failure isolation.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-check text-xl text-blue-400'></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">High Availability</h4>
                            <p class="text-sm text-gray-500">Multi-region deployments, load balancing, and automated failovers.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=web" class="btn-outline px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2 hover:bg-white hover:text-black hover:border-white transition-all">
                    Estimate Web Project <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="glass-panel rounded-3xl p-2 relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/20 to-transparent opacity-50 rounded-3xl blur-xl"></div>
                    <div class="bg-[#0a0a0a] border border-white/10 rounded-2xl h-[400px] flex flex-col overflow-hidden relative z-10">
                        <div class="h-10 border-b border-white/10 flex items-center px-4 gap-2 bg-[#111111]">
                            <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                        </div>
                        <div class="flex-grow p-6 flex items-center justify-center">
                            <div class="w-full space-y-4">
                                <div class="h-4 bg-white/5 rounded w-1/4 animate-pulse"></div>
                                <div class="h-12 bg-white/5 rounded w-3/4 animate-pulse"></div>
                                <div class="h-4 bg-white/5 rounded w-full animate-pulse delay-75"></div>
                                <div class="h-4 bg-white/5 rounded w-5/6 animate-pulse delay-100"></div>
                                <div class="h-32 bg-gradient-to-r from-blue-500/10 to-transparent rounded mt-8 border border-blue-500/20"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Engineering -->
    <section id="mobile" class="scroll-mt-32 relative">
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-purple-600/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-1 lg:order-1" data-aos="fade-right">
                <div class="glass-panel rounded-3xl p-2 relative w-3/4 mx-auto lg:w-full lg:mx-0">
                    <div class="absolute inset-0 bg-gradient-to-tr from-purple-500/20 to-transparent opacity-50 rounded-3xl blur-xl"></div>
                    <div class="bg-[#0a0a0a] border border-white/10 rounded-3xl h-[500px] flex flex-col overflow-hidden relative z-10 w-[250px] mx-auto my-4 shadow-2xl">
                        <div class="h-6 w-32 bg-black rounded-b-xl mx-auto absolute top-0 left-1/2 -translate-x-1/2 z-20"></div>
                        <div class="flex-grow p-4 pt-10 flex flex-col gap-4 relative">
                            <div class="h-32 rounded-xl bg-gradient-to-br from-purple-500/20 to-blue-500/20 border border-white/5"></div>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="h-16 rounded-xl bg-white/5 animate-pulse"></div>
                                <div class="h-16 rounded-xl bg-white/5 animate-pulse delay-75"></div>
                            </div>
                            <div class="h-12 rounded-xl bg-white/5 mt-auto"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-2 lg:order-2" data-aos="fade-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-purple-500/20 bg-purple-500/5 text-purple-400 text-xs font-bold tracking-widest uppercase mb-8">
                    <i class='bx bx-mobile-alt'></i> Mobile Engineering
                </div>
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Native & Cross-Platform</h2>
                <p class="text-gray-400 mb-8 leading-relaxed font-light text-lg">
                    Deliver seamless, fluid mobile experiences to your users wherever they are. We specialize in building iOS and Android applications that leverage native device capabilities while maintaining perfectly synchronized state with your cloud architecture.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bxl-apple text-xl text-white'></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">iOS Native (Swift)</h4>
                            <p class="text-sm text-gray-500">Uncompromised performance and Apple ecosystem integration.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bxl-android text-xl text-green-400'></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Android Native (Kotlin)</h4>
                            <p class="text-sm text-gray-500">Robust architectures utilizing Jetpack Compose and modern Android APIs.</p>
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
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-accent-600/10 rounded-full blur-[120px] mix-blend-screen pointer-events-none"></div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-accent-500/20 bg-accent-500/5 text-accent-400 text-xs font-bold tracking-widest uppercase mb-8">
                    <i class='bx bx-brain'></i> AI & Data
                </div>
                <h2 class="text-4xl font-black font-['Outfit'] mb-6 tracking-tight">Applied Artificial Intelligence</h2>
                <p class="text-gray-400 mb-8 leading-relaxed font-light text-lg">
                    Move beyond basic API wrappers. We architect deep AI integrations, building private RAG (Retrieval-Augmented Generation) pipelines, autonomous agent swarms, and predictive models trained on your proprietary data securely.
                </p>
                <div class="space-y-6 mb-10">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-data text-xl text-accent-400'></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Vector Databases & RAG</h4>
                            <p class="text-sm text-gray-500">Semantic search and document Q&A over millions of private records.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                            <i class='bx bx-bot text-xl text-accent-400'></i>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-1">Autonomous Workflows</h4>
                            <p class="text-sm text-gray-500">AI agents that execute complex, multi-step business logic autonomously.</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('businzo.estimate') }}?type=ai" class="btn-outline px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2 hover:bg-white hover:text-black hover:border-white transition-all">
                    Estimate AI Integration <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="glass-panel rounded-3xl p-2 relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-accent-500/20 to-transparent opacity-50 rounded-3xl blur-xl"></div>
                    <div class="bg-[#0a0a0a] border border-white/10 rounded-2xl h-[400px] flex items-center justify-center overflow-hidden relative z-10">
                        <!-- Abstract AI Node Graphic -->
                        <div class="relative w-64 h-64">
                            <div class="absolute inset-0 border border-accent-500/30 rounded-full animate-[spin_10s_linear_infinite]"></div>
                            <div class="absolute inset-4 border border-blue-500/30 rounded-full animate-[spin_15s_linear_infinite_reverse]"></div>
                            <div class="absolute inset-8 border border-purple-500/30 rounded-full animate-[spin_20s_linear_infinite]"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 bg-gradient-to-br from-accent-400 to-blue-600 rounded-full blur-[2px] shadow-[0_0_50px_rgba(0,223,216,0.5)]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- Global CTA -->
<section class="py-24 border-t border-white/5 bg-background">
    <div class="max-w-4xl mx-auto text-center px-6" data-aos="zoom-in">
        <h2 class="text-3xl font-black mb-6 font-['Outfit']">Not sure where to start?</h2>
        <p class="text-gray-400 mb-8">Schedule a technical consultation with our engineering architects to discuss your infrastructure, requirements, and feasibility.</p>
        <a href="{{ route('businzo.contact') }}" class="text-white hover:text-blue-400 font-bold underline underline-offset-8 transition-colors">Book a Consultation -></a>
    </div>
</section>
@endsection
