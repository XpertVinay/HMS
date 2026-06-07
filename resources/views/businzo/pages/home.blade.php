@extends('businzo.layouts.app')

@section('title', 'Businzo | Premium IT & Software Engineering')

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


                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black leading-[1.1] tracking-tight" data-aos="fade-right" data-aos-delay="100">
                        Engineer the <br>
                        <span class="gradient-text-accent">Impossible.</span>
                    </h1>

                    <p class="text-lg md:text-xl text-gray-400 leading-relaxed font-light" data-aos="fade-right" data-aos-delay="200">
                        We are a premier software engineering agency building scalable architectures, native applications,
                        and autonomous AI systems for market leaders.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('businzo.estimate') }}"
                            class="btn-premium px-8 py-4 rounded-full text-center flex items-center justify-center gap-2 font-bold group w-full sm:w-auto">
                            Start Building
                            <i class='bx bx-right-arrow-alt text-xl group-hover:translate-x-1 transition-transform'></i>
                        </a>
                        <a href="{{ route('businzo.services') }}"
                            class="btn-outline px-8 py-4 rounded-full text-center flex items-center justify-center font-bold w-full sm:w-auto">
                            View Expertise
                        </a>
                    </div>

                    <div data-aos="fade-up" data-aos-delay="400"
                        class="flex items-center gap-6 pt-10 border-t border-white/10 text-sm font-medium text-gray-500">
                        <div class="flex items-center gap-2"><i class='bx bx-check-circle text-gray-400'></i> High
                            Performance</div>
                        <div class="flex items-center gap-2"><i class='bx bx-check-circle text-gray-400'></i> ISO 27001
                            Security</div>
                        <div class="flex items-center gap-2"><i class='bx bx-check-circle text-gray-400'></i> Dedicated
                            Teams</div>
                    </div>
                </div>

                <div class="relative lg:block hidden" data-aos="zoom-in-up" data-aos-duration="1000">
                    <!-- High-quality generated mockup -->
                    <div
                        class="relative w-full rounded-2xl overflow-hidden shadow-2xl shadow-primary/20 transform transition-all hover:scale-[1.02] duration-500 border border-white/10">
                        <img src="{{ asset('assets/images/businzo/hero.png') }}" alt="Businzo Dashboard Mockup"
                            class="w-full h-auto object-cover opacity-90 hover:opacity-100 transition-opacity">
                        <!-- Glassmorphism overlay for extra depth -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-primary/10 to-accent/10 mix-blend-overlay">
                        </div>
                    </div>

                    <!-- Floating stat card -->
                    <div class="absolute -bottom-8 -left-8 glass-panel p-6 rounded-2xl animate-[bounce_5s_infinite]">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-blue-300">
                                <i class='bx bx-line-chart text-2xl'></i>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">System Uptime
                                </div>
                                <div class="text-2xl font-black text-white">99.99%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Logo Marquee (Trusted By) -->
    <section class="py-12 border-y border-white/5 bg-[#070b1a]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <p class="text-center text-sm font-bold tracking-widest text-gray-500 uppercase mb-8">Trusted by
                forward-thinking companies</p>
            <div class="flex flex-wrap justify-center items-center gap-x-16 gap-y-8 opacity-50 grayscale" data-aos="fade-up">
                <i class='bx bxl-aws text-5xl hover:grayscale-0 hover:opacity-100 transition-all cursor-pointer'></i>
                <i
                    class='bx bxl-google-cloud text-5xl hover:grayscale-0 hover:opacity-100 transition-all cursor-pointer'></i>
                <i class='bx bxl-stripe text-5xl hover:grayscale-0 hover:opacity-100 transition-all cursor-pointer'></i>
                <i class='bx bxl-react text-5xl hover:grayscale-0 hover:opacity-100 transition-all cursor-pointer'></i>
                <i
                    class='bx bxl-tailwind-css text-5xl hover:grayscale-0 hover:opacity-100 transition-all cursor-pointer'></i>
            </div>
        </div>
    </section>

    <!-- Bento Box Services Section -->
    <section class="py-32 relative z-10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="max-w-3xl mb-20" data-aos="fade-up">
                <h2 class="text-sm font-bold tracking-widest text-accent uppercase mb-4">Core Architecture</h2>
                <h3 class="text-4xl md:text-5xl font-black mb-6">Everything you need to <br><span
                        class="text-gray-500">scale infinitely.</span></h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Bento Box 1: Web (Large) -->
                <div
                    class="md:col-span-2 glass-panel p-8 md:p-12 rounded-3xl group relative overflow-hidden transition-all hover:bg-white/[0.02]" data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-primary/10 blur-[80px] rounded-full group-hover:bg-primary/20 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <i class='bx bx-layer text-4xl text-primary mb-6'></i>
                        <h4 class="text-2xl font-bold mb-4">Enterprise Web Systems</h4>
                        <p class="text-gray-400 mb-8 max-w-md leading-relaxed">
                            High-performance frontend architecture paired with secure, highly-available backend systems. We
                            build platforms designed to handle millions of requests seamlessly.
                        </p>
                        <a href="{{ route('businzo.services') }}#web"
                            class="text-white font-semibold flex items-center gap-2 hover:text-primary transition-colors">
                            Explore Web Architecture <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>

                <!-- Bento Box 2: Mobile -->
                <div
                    class="glass-panel p-8 md:p-12 rounded-3xl group relative overflow-hidden transition-all hover:bg-white/[0.02]" data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-accent/10 blur-[50px] rounded-full group-hover:bg-accent/20 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <i class='bx bx-mobile text-4xl text-accent mb-6'></i>
                        <h4 class="text-2xl font-bold mb-4">Native Mobile</h4>
                        <p class="text-gray-400 mb-8 leading-relaxed">
                            Fluid iOS and Android experiences built with Swift, Kotlin, or React Native.
                        </p>
                        <a href="{{ route('businzo.services') }}#mobile"
                            class="text-white font-semibold flex items-center gap-2 hover:text-accent transition-colors">
                            Mobile App Dev <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>

                <!-- Bento Box 3: AI -->
                <div
                    class="glass-panel p-8 md:p-12 rounded-3xl group relative overflow-hidden transition-all hover:bg-white/[0.02]">
                    <div
                        class="absolute bottom-0 left-0 w-48 h-48 bg-blue-500/10 blur-[60px] rounded-full group-hover:bg-blue-500/20 transition-colors">
                    </div>
                    <div class="relative z-10">
                        <i class='bx bx-network-chart text-4xl text-blue-400 mb-6'></i>
                        <h4 class="text-2xl font-bold mb-4">Applied AI & RAG</h4>
                        <p class="text-gray-400 mb-8 leading-relaxed">
                            Integrate custom LLMs and semantic search directly into your business workflows.
                        </p>
                        <a href="{{ route('businzo.services') }}#ai"
                            class="text-white font-semibold flex items-center gap-2 hover:text-blue-400 transition-colors">
                            AI Integration <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>

                <!-- Bento Box 4: Custom Software (Large) -->
                <div
                    class="md:col-span-2 glass-panel p-8 md:p-12 rounded-3xl group relative overflow-hidden transition-all hover:bg-white/[0.02]">
                    <div
                        class="absolute top-1/2 right-10 w-[200px] h-[200px] border border-white/5 rounded-full flex items-center justify-center -translate-y-1/2">
                        <div
                            class="w-[150px] h-[150px] border border-white/5 rounded-full flex items-center justify-center">
                            <i class='bx bx-code-block text-6xl text-white/10'></i>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <i class='bx bx-cube-alt text-4xl text-red-400 mb-6'></i>
                        <h4 class="text-2xl font-bold mb-4">Bespoke Software Solutions</h4>
                        <p class="text-gray-400 mb-8 max-w-md leading-relaxed">
                            When off-the-shelf doesn't cut it. We architect custom SaaS platforms, complex ERPs, and
                            specialized internal tools from the ground up.
                        </p>
                        <a href="{{ route('businzo.services') }}#custom"
                            class="text-white font-semibold flex items-center gap-2 hover:text-red-400 transition-colors">
                            Custom Engineering <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-32 relative overflow-hidden border-t border-white/5">
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] [mask-image:radial-gradient(ellipse_at_center,black,transparent_70%)] opacity-50 z-0">
        </div>

        <div class="max-w-4xl mx-auto px-6 lg:px-8 relative z-10 text-center" data-aos="zoom-in" data-aos-duration="1000">
            <h2 class="text-4xl md:text-6xl font-black mb-8 tracking-tight">Ready to initiate <br><span
                    class="text-gray-500">your next project?</span></h2>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-12">
                <a href="{{ route('businzo.estimate') }}"
                    class="btn-premium px-10 py-4 rounded-full font-bold text-lg inline-flex items-center justify-center gap-2">
                    <i class='bx bx-calculator text-2xl'></i> Get an Estimate
                </a>
                <a href="{{ route('businzo.contact') }}"
                    class="btn-outline px-10 py-4 rounded-full font-bold text-lg inline-flex items-center justify-center">
                    Contact Sales
                </a>
            </div>
        </div>
    </section>
@endsection