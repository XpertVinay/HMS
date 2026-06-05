<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Businzo RCMS') | {{ $activeOrg->name ?? 'Community Portal' }}</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    <link rel="manifest" href="/manifest.json">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: {{ $activeOrg->resolved_primary_color ?? '#4f46e5' }};
            --secondary-color: {{ $activeOrg->resolved_secondary_color ?? '#1e1b4b' }};
            --sidebar-bg: var(--secondary-color);
            --accent: var(--primary-color);
        }
        
        body {
            background-color: #f4f7fe; /* Sleek light modern background */
            -webkit-font-smoothing: antialiased;
        }

        /* Essential Custom Styles over Tailwind */
        .sidebar {
            width: 280px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar.close {
            width: 90px;
        }
        .home-section {
            width: calc(100% - 280px);
            margin-left: 280px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar.close ~ .home-section {
            width: calc(100% - 90px);
            margin-left: 90px;
        }

        /* Hide sidebar completely on mobile */
        @media (max-width: 768px) {
            .sidebar { left: -280px; }
            .sidebar.active { left: 0; }
            .home-section { width: 100%; margin-left: 0; }
            .sidebar.active ~ .home-section { margin-left: 0; width: 100%; }
        }

        /* Glassmorphism Utilities */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Modern Scrollbar for Sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }

        /* Floating Chat Button Animation */
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(var(--primary-color), 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(var(--primary-color), 0); }
            100% { box-shadow: 0 0 0 0 rgba(var(--primary-color), 0); }
        }
        .chat-btn-pulse {
            animation: pulse-ring 2s infinite;
        }
    </style>
    @stack('styles')
</head>
<body class="text-slate-700 font-sans antialiased overflow-x-hidden">
    @include('partials.sidebar')

    <section class="home-section min-h-screen flex flex-col">
        @include('partials.navbar')

        <div class="home-content p-6 lg:p-10 flex-grow max-w-[1600px] w-full mx-auto">
            {{-- Flash messages with Tailwind styling --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center gap-3 shadow-sm animate-[fadeInDown_0.5s_ease-out]">
                    <i class='bx bx-check-circle text-2xl'></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-100 text-red-700 flex items-center gap-3 shadow-sm animate-[fadeInDown_0.5s_ease-out]">
                    <i class='bx bx-error-circle text-2xl'></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-5 rounded-2xl bg-red-50 border border-red-100 text-red-700 shadow-sm animate-[fadeInDown_0.5s_ease-out]">
                    <div class="flex items-center gap-2 mb-3"><i class='bx bx-error-circle text-2xl'></i> <strong class="font-semibold">Please fix the following errors:</strong></div>
                    <ul class="pl-8 list-disc space-y-1 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </section>

    {{-- Floating Chat --}}
    <a href="javascript:void(0)" class="fixed bottom-8 right-8 w-16 h-16 rounded-full flex items-center justify-center text-3xl text-white shadow-xl chat-btn-pulse transition-transform hover:scale-110 z-50" style="background: linear-gradient(135deg, var(--primary-color), #6366f1)">
        <i class='bx bx-message-rounded-dots'></i>
    </a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle
        let sidebar = document.querySelector('.sidebar');
        let sidebarBtn = document.querySelector('.sidebarBtn');
        if (sidebarBtn) {
            sidebarBtn.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    sidebar.classList.toggle('active');
                    sidebar.classList.remove('close');
                } else {
                    sidebar.classList.toggle('close');
                    sidebar.classList.remove('active');
                }
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
