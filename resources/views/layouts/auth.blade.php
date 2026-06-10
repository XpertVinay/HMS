<!DOCTYPE html>
<html lang="en" data-theme="{{ $themeMode ?? 'light' }}">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>@yield('title', 'Login') | {{ $activeOrg->name ?? 'Businzo RCMS' }}</title>
     <link rel="shortcut icon"
          href="{{ $theme->favicon ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">

     @include('partials.theme-variables')
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen relative flex items-center justify-center font-sans text-white antialiased overflow-x-hidden @yield('theme-class', '')"
     style="background: var(--color-secondary);">
     <!-- Dynamic Mesh/Gradient Background -->
     <div class="absolute inset-0 z-0 pointer-events-none">
          <div class="absolute top-0 left-0 w-full h-full opacity-60"
               style="background: radial-gradient(ellipse at top right, var(--color-primary), var(--color-secondary), var(--color-secondary));">
          </div>
          <div class="absolute bottom-0 right-0 w-3/4 h-3/4 opacity-40"
               style="background: radial-gradient(ellipse at bottom left, var(--color-accent), transparent, transparent);">
          </div>
     </div>

     <!-- Decorative Floating Orbs -->
     <div class="absolute top-[-10%] left-[-10%] w-96 h-96 rounded-full mix-blend-screen filter blur-[100px] opacity-30 animate-pulse pointer-events-none"
          style="background: var(--color-primary);"></div>
     <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 rounded-full mix-blend-screen filter blur-[120px] opacity-20 pointer-events-none"
          style="background: var(--color-accent); animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;"></div>

     <div class="relative z-10 w-full px-4 py-8 flex justify-center">
          @yield('content')
     </div>

     <!--Start of Tawk.to Script-->
     <script type="text/javascript">
          var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
          (function () {
               var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
               s1.async = true;
               s1.src = 'https://embed.tawk.to/6a28fd25135ef41c3064c772/1jqo1pni0';
               s1.charset = 'UTF-8';
               s1.setAttribute('crossorigin', '*');
               s0.parentNode.insertBefore(s1, s0);
          })();
     </script>
     <!--End of Tawk.to Script-->
</body>

</html>