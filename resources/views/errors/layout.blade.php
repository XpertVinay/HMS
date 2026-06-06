<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | {{ $activeOrg->name ?? config('app.name', 'Businzo RCMS') }}</title>
    <link rel="shortcut icon" href="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: {{ $activeOrg->resolved_primary_color ?? '#E6192B' }};
            --secondary: {{ $activeOrg->resolved_secondary_color ?? '#1E2B58' }};
        }
        
        /* Fallback styles in case Tailwind doesn't load */
        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--secondary);
            color: #ffffff;
            min-height: 100vh;
            overflow-x: hidden;
        }
    </style>
</head>
<body class="min-h-screen relative flex items-center justify-center font-sans text-white antialiased overflow-x-hidden bg-[var(--secondary)]">
    <!-- Dynamic Mesh/Gradient Background -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-full opacity-60 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-primary via-secondary to-secondary"></div>
        <div class="absolute bottom-0 right-0 w-3/4 h-3/4 opacity-40 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-purple-500/30 via-transparent to-transparent"></div>
    </div>
    
    <!-- Decorative Floating Orbs -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-[var(--primary)] rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-500 rounded-full mix-blend-screen filter blur-[120px] opacity-20 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;"></div>

    <div class="relative z-10 w-full px-4 py-8 flex justify-center text-center">
        <div class="max-w-xl mx-auto backdrop-blur-md bg-white/10 p-12 rounded-[2rem] shadow-2xl border border-white/20">
            <div class="text-3xl md:text-4xl font-extrabold text-white/90 tracking-widest mb-10">
                @yield('message')
            </div>
            
            <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-xl text-[var(--secondary)] bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary)] transition-all duration-300 transform hover:scale-105 shadow-[0_0_20px_rgba(255,255,255,0.3)]">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Return Home
            </a>
        </div>
    </div>
</body>
</html>
