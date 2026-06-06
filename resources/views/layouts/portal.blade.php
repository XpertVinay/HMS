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
            --secondary-color: {{ $activeOrg->resolved_secondary_color ?? '#1d1b31' }};
            --sidebar-bg: var(--secondary-color);
            --accent: var(--primary-color);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', 'Inter', sans-serif; }

        body {
            background-color: #f8fafc;
            color: #334155;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Sidebar ─────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            height: 100%; width: 260px;
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0f172a 100%);
            padding: 12px 14px;
            z-index: 99;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 4px 0 24px rgba(0,0,0,0.05);
        }
        .sidebar.close { width: 88px; }
        .sidebar .logo-details {
            height: 70px; display: flex; align-items: center;
            padding: 0 10px; margin-bottom: 10px;
        }
        .sidebar .logo-details img {
            max-height: 48px; width: auto; object-fit: contain;
            background: rgba(255,255,255,0.95); padding: 8px; border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .sidebar .nav-links {
            list-style: none; margin-top: 10px;
            height: calc(100% - 90px); overflow-y: auto;
            padding: 0;
        }
        .sidebar .nav-links::-webkit-scrollbar { width: 5px; }
        .sidebar .nav-links::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .sidebar .nav-links li { position: relative; margin: 6px 0; }
        .sidebar .nav-links li a {
            display: flex; align-items: center;
            text-decoration: none; color: rgba(255,255,255,0.6);
            padding: 12px 14px; border-radius: 12px;
            transition: all 0.3s ease;
            white-space: nowrap; font-weight: 500;
        }
        .sidebar .nav-links li a:hover,
        .sidebar .nav-links li a.active {
            background: rgba(255,255,255,0.1); color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .sidebar .nav-links li a.active {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(var(--primary-color), 0.4);
        }
        .sidebar .nav-links li a i {
            min-width: 40px; font-size: 22px; text-align: center;
        }
        .sidebar .nav-links li a .links_name {
            font-size: 15px;
        }
        .sidebar.close .nav-links li a .links_name { display: none; }

        /* ── Top Navbar ─────────────────────────── */
        .home-section {
            position: relative; left: 260px;
            width: calc(100% - 260px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
        }
        .sidebar.close ~ .home-section { left: 88px; width: calc(100% - 88px); }

        .home-section nav {
            display: flex; justify-content: space-between;
            align-items: center; padding: 16px 32px;
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(12px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky; top: 0; z-index: 50;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .sidebar-button { display: flex; align-items: center; gap: 16px; }
        .sidebar-button .sidebarBtn { font-size: 28px; cursor: pointer; color: #475569; transition: color 0.3s; }
        .sidebar-button .sidebarBtn:hover { color: var(--primary-color); }
        .sidebar-button .dashboard { font-size: 20px; font-weight: 700; color: #1e293b; letter-spacing: -0.02em; }

        .profile-details {
            display: flex; align-items: center; gap: 12px; cursor: pointer;
            background: white; padding: 6px 16px 6px 6px; border-radius: 30px;
            border: 1px solid #e2e8f0; box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            transition: all 0.3s;
        }
        .profile-details:hover { border-color: #cbd5e1; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .profile-details .avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, #8b5cf6 100%); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .admin_name { font-weight: 600; font-size: 14px; color: #475569; }

        /* ── Content Area ──────────────────────── */
        .home-content {
            padding: 32px;
            max-width: 1400px; margin: 0 auto;
        }

        /* ── Overview Boxes ────────────────────── */
        .overview-boxes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 24px; margin-bottom: 32px;
        }
        .overview-boxes .box {
            display: flex; align-items: center; justify-content: space-between;
            background: #fff; padding: 24px;
            border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            border: 1px solid #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .overview-boxes .box:hover { transform: translateY(-4px); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); border-color: #e2e8f0; }
        .overview-boxes .box .box-topic { font-size: 14px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .overview-boxes .box .number { font-size: 28px; font-weight: 800; color: #0f172a; margin-top: 6px; }
        .overview-boxes .box .icon {
            width: 56px; height: 56px; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
        }
        .icon.member { background: #fef2f2; color: #ef4444; }
        .icon.staff { background: #eff6ff; color: #3b82f6; }
        .icon.money { background: #f0fdf4; color: #22c55e; }
        .icon.file { background: #fffbeb; color: #f59e0b; }

        /* ── Data Panels ───────────────────────── */
        .sales-boxes {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
            gap: 24px;
        }
        .sales-boxes .box {
            background: #fff; padding: 24px; border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
        }
        .box-title {
            font-size: 18px; font-weight: 700; color: #1e293b;
            margin-bottom: 20px; padding-bottom: 12px;
            border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; gap: 8px;
        }

        /* ── Tables ────────────────────────────── */
        .data-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .data-table th {
            background: #f8fafc; padding: 14px 16px;
            text-align: left; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            color: #64748b; border-bottom: 1px solid #e2e8f0;
        }
        .data-table th:first-child { border-top-left-radius: 12px; }
        .data-table th:last-child { border-top-right-radius: 12px; }
        .data-table td {
            padding: 14px 16px; font-size: 14px; color: #334155; font-weight: 500;
            border-bottom: 1px solid #f1f5f9; transition: background 0.2s;
        }
        .data-table tr:hover td { background: #f8fafc; }
        .data-table tr:last-child td { border-bottom: none; }

        /* ── Buttons ───────────────────────────── */
        .btn-modern {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            padding: 10px 24px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #4338ca 100%); color: #fff;
            border: none; border-radius: 12px;
            font-weight: 600; font-size: 14px;
            cursor: pointer; text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-modern:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.15); color: #fff; text-decoration: none; }
        .btn-modern.btn-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
        .btn-modern.btn-success { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .btn-modern.btn-outline {
            background: transparent; color: var(--primary-color);
            border: 2px solid var(--primary-color); box-shadow: none;
        }
        .btn-modern.btn-outline:hover { background: var(--primary-color); color: white; }
        .btn-modern.btn-sm { padding: 6px 14px; font-size: 13px; border-radius: 8px; }

        /* ── Forms ──────────────────────────────── */
        .form-card {
            background: #fff; padding: 32px; border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
            max-width: 650px; margin: 0 auto;
        }
        .form-card .form-group { margin-bottom: 20px; }
        .form-card label { font-size: 14px; font-weight: 600; color: #475569; margin-bottom: 8px; display: block; }
        .form-card input, .form-card select, .form-card textarea {
            width: 100%; padding: 12px 16px; border: 1px solid #cbd5e1;
            border-radius: 10px; font-size: 15px; color: #334155; transition: all 0.2s;
            background-color: #f8fafc;
        }
        .form-card input:focus, .form-card select:focus, .form-card textarea:focus {
            background-color: #fff;
            border-color: var(--primary-color); outline: none;
            box-shadow: 0 0 0 4px rgba(79,70,229,0.15);
        }

        /* ── Alerts ────────────────────────────── */
        .alert-custom {
            padding: 16px 20px; border-radius: 12px;
            margin-bottom: 24px; font-size: 14px; font-weight: 500;
            display: flex; align-items: center; gap: 12px;
            animation: fadeInDown 0.5s ease forwards;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert-custom.success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; border-left: 4px solid #16a34a; }
        .alert-custom.error { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; border-left: 4px solid #dc2626; }

        /* ── Status Badges ─────────────────────── */
        .badge-status {
            padding: 6px 12px; border-radius: 30px;
            font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            display: inline-flex; align-items: center; gap: 4px;
        }
        .badge-status.paid, .badge-status.approved, .badge-status.resolved { background: #dcfce7; color: #166534; }
        .badge-status.pending { background: #fef9c3; color: #854d0e; }
        .badge-status.unpaid, .badge-status.rejected { background: #fee2e2; color: #991b1b; }
        .badge-status.in_progress { background: #e0f2fe; color: #075985; }

        /* ── Floating Chat Button ──────────────── */
        .floating-chat-btn {
            position: fixed; bottom: 32px; right: 32px;
            width: 64px; height: 64px; border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, #4338ca 100%); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px; box-shadow: 0 10px 25px rgba(79,70,229,0.4);
            text-decoration: none; z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .floating-chat-btn:hover { transform: scale(1.1) translateY(-4px); color: #fff; box-shadow: 0 15px 30px rgba(79,70,229,0.5); }

        /* ── Responsive ────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { left: -260px; width: 260px; }
            .sidebar.active { left: 0; }
            .sidebar .nav-links li a .links_name { display: block; }
            .home-section { left: 0; width: 100%; }
            .sidebar.active ~ .home-section { left: 0; width: 100%; }
            /* When sidebar is open on mobile, maybe add a darkened overlay, or just cover the screen */
            .overview-boxes { grid-template-columns: 1fr; }
            .sales-boxes { grid-template-columns: 1fr; }
            .home-content { padding: 16px; }
            .home-section nav { padding: 12px 16px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('partials.sidebar')

    <section class="home-section">
        @include('partials.navbar')

        <div class="home-content">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert-custom success"><i class='bx bx-check-circle text-xl'></i> {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-custom error"><i class='bx bx-error-circle text-xl'></i> {{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-custom error flex-col items-start">
                    <div class="flex items-center gap-2 mb-2"><i class='bx bx-error-circle text-xl'></i> <strong>Please fix the following errors:</strong></div>
                    <ul class="mb-0 pl-6 list-disc w-full">
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
    <a href="javascript:void(0)" class="floating-chat-btn">
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
