<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') | {{ $activeOrg->name ?? 'Businzo RCMS' }}</title>
    <link rel="shortcut icon" href="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: {{ $activeOrg->resolved_primary_color ?? '#E6192B' }};
            --secondary: {{ $activeOrg->resolved_secondary_color ?? '#1E2B58' }};
        }
    </style>
</head>
<body class="min-h-screen relative flex items-center justify-center font-sans text-white antialiased overflow-x-hidden @yield('theme-class', '') bg-[var(--secondary)]">
    <!-- Dynamic Mesh/Gradient Background -->
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 left-0 w-full h-full opacity-60 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-primary via-secondary to-secondary"></div>
        <div class="absolute bottom-0 right-0 w-3/4 h-3/4 opacity-40 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-purple-500/30 via-transparent to-transparent"></div>
    </div>
    
    <!-- Decorative Floating Orbs -->
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-[var(--primary)] rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-pulse pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-500 rounded-full mix-blend-screen filter blur-[120px] opacity-20 pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;"></div>

    <div class="relative z-10 w-full px-4 py-8 flex justify-center">
        @yield('content')
    </div>
</body>
</html>
