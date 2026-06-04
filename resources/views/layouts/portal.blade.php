<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Businzo RCMS') | {{ $activeOrg->name ?? 'Community Portal' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    <link rel="manifest" href="/manifest.json">
    <style>
        :root {
            --primary-color: {{ $activeOrg->resolved_primary_color ?? '#4f46e5' }};
            --secondary-color: {{ $activeOrg->resolved_secondary_color ?? '#1d1b31' }};
            --sidebar-bg: var(--secondary-color);
            --accent: var(--primary-color);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        /* ── Sidebar ─────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0;
            height: 100%; width: 250px;
            background: var(--sidebar-bg);
            padding: 6px 14px;
            z-index: 99;
            transition: all 0.3s ease;
        }
        .sidebar.close { width: 78px; }
        .sidebar .logo-details {
            height: 60px; display: flex; align-items: center;
            padding: 0 6px;
        }
        .sidebar .logo-details img {
            max-height: 40px; width: auto; object-fit: contain;
            background: rgba(255,255,255,0.95); padding: 5px 12px; border-radius: 6px;
        }
        .sidebar .nav-links {
            list-style: none; margin-top: 10px;
            height: calc(100% - 70px); overflow-y: auto;
            padding: 0;
        }
        .sidebar .nav-links::-webkit-scrollbar { display: none; }
        .sidebar .nav-links li { position: relative; margin: 4px 0; }
        .sidebar .nav-links li a {
            display: flex; align-items: center;
            text-decoration: none; color: rgba(255,255,255,0.7);
            padding: 10px 12px; border-radius: 8px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        .sidebar .nav-links li a:hover,
        .sidebar .nav-links li a.active {
            background: rgba(255,255,255,0.1); color: #fff;
        }
        .sidebar .nav-links li a i {
            min-width: 35px; font-size: 20px; text-align: center;
        }
        .sidebar .nav-links li a .links_name {
            font-size: 14px; font-weight: 500;
        }
        .sidebar.close .nav-links li a .links_name { display: none; }

        /* ── Top Navbar ─────────────────────────── */
        .home-section {
            position: relative; left: 250px;
            width: calc(100% - 250px);
            transition: all 0.3s ease;
            min-height: 100vh; background: #f5f6fa;
        }
        .sidebar.close ~ .home-section { left: 78px; width: calc(100% - 78px); }

        .home-section nav {
            display: flex; justify-content: space-between;
            align-items: center; padding: 12px 24px;
            background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.08);
            position: sticky; top: 0; z-index: 50;
        }
        .sidebar-button { display: flex; align-items: center; gap: 10px; }
        .sidebar-button .sidebarBtn { font-size: 24px; cursor: pointer; color: #333; }
        .sidebar-button .dashboard { font-size: 16px; font-weight: 600; color: #333; }

        .profile-details {
            display: flex; align-items: center; gap: 10px; cursor: pointer;
        }
        .profile-details .avatar {
            width: 32px; height: 32px; border-radius: 50%;
            background: var(--primary-color); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 14px;
        }
        .admin_name { font-weight: 600; font-size: 14px; }

        /* ── Content Area ──────────────────────── */
        .home-content {
            padding: 24px;
        }

        /* ── Overview Boxes ────────────────────── */
        .overview-boxes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px; margin-bottom: 24px;
        }
        .overview-boxes .box {
            display: flex; align-items: center; justify-content: space-between;
            background: #fff; padding: 20px;
            border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: transform 0.2s ease;
        }
        .overview-boxes .box:hover { transform: translateY(-2px); }
        .overview-boxes .box .box-topic { font-size: 13px; color: #888; font-weight: 500; }
        .overview-boxes .box .number { font-size: 22px; font-weight: 700; color: #333; margin-top: 4px; }
        .overview-boxes .box .icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
        }
        .icon.member { background: #ffe0e6; color: #e74c3c; }
        .icon.staff { background: #d4e6ff; color: #3498db; }
        .icon.money { background: #d4f8e0; color: #27ae60; }
        .icon.file { background: #ffecd2; color: #f39c12; }

        /* ── Data Panels ───────────────────────── */
        .sales-boxes {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 16px;
        }
        .sales-boxes .box {
            background: #fff; padding: 20px; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .box-title {
            font-size: 16px; font-weight: 700; color: #333;
            margin-bottom: 16px; padding-bottom: 8px;
            border-bottom: 2px solid #f0f0f0;
        }

        /* ── Tables ────────────────────────────── */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            background: #f8f9fa; padding: 10px 12px;
            text-align: left; font-size: 13px; font-weight: 600;
            color: #555; border-bottom: 2px solid #e9ecef;
        }
        .data-table td {
            padding: 10px 12px; font-size: 13px; color: #333;
            border-bottom: 1px solid #f0f0f0;
        }
        .data-table tr:hover { background: #fafbfc; }

        /* ── Buttons ───────────────────────────── */
        .btn-modern {
            display: inline-block; padding: 8px 20px;
            background: var(--primary-color); color: #fff;
            border: none; border-radius: 8px;
            font-weight: 600; font-size: 13px;
            cursor: pointer; text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-modern:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; text-decoration: none; }
        .btn-modern.btn-danger { background: #e74c3c; }
        .btn-modern.btn-success { background: #27ae60; }
        .btn-modern.btn-outline {
            background: transparent; color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        .btn-modern.btn-sm { padding: 5px 12px; font-size: 12px; }

        /* ── Forms ──────────────────────────────── */
        .form-card {
            background: #fff; padding: 24px; border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            max-width: 600px;
        }
        .form-card .form-group { margin-bottom: 16px; }
        .form-card label { font-size: 13px; font-weight: 600; color: #555; margin-bottom: 6px; display: block; }
        .form-card input, .form-card select, .form-card textarea {
            width: 100%; padding: 10px 14px; border: 1px solid #ddd;
            border-radius: 8px; font-size: 14px; transition: border-color 0.2s;
        }
        .form-card input:focus, .form-card select:focus, .form-card textarea:focus {
            border-color: var(--primary-color); outline: none;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
        }

        /* ── Alerts ────────────────────────────── */
        .alert-custom {
            padding: 12px 16px; border-radius: 8px;
            margin-bottom: 16px; font-size: 14px;
        }
        .alert-custom.success { background: #d4f8e0; color: #155724; border: 1px solid #c3e6cb; }
        .alert-custom.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* ── Status Badges ─────────────────────── */
        .badge-status {
            padding: 4px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600; text-transform: uppercase;
        }
        .badge-status.paid, .badge-status.approved, .badge-status.resolved { background: #d4f8e0; color: #155724; }
        .badge-status.pending { background: #fff3cd; color: #856404; }
        .badge-status.unpaid, .badge-status.rejected { background: #f8d7da; color: #721c24; }
        .badge-status.in_progress { background: #d4e6ff; color: #004085; }

        /* ── Floating Chat Button ──────────────── */
        .floating-chat-btn {
            position: fixed; bottom: 24px; right: 24px;
            width: 56px; height: 56px; border-radius: 50%;
            background: var(--primary-color); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; box-shadow: 0 4px 16px rgba(0,0,0,0.2);
            text-decoration: none; z-index: 1000;
            transition: transform 0.2s;
        }
        .floating-chat-btn:hover { transform: scale(1.1); color: #fff; }

        /* ── Responsive ────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { width: 78px; }
            .sidebar .nav-links li a .links_name { display: none; }
            .home-section { left: 78px; width: calc(100% - 78px); }
            .overview-boxes { grid-template-columns: 1fr 1fr; }
            .sales-boxes { grid-template-columns: 1fr; }
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
                <div class="alert-custom success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert-custom error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert-custom error">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
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
                sidebar.classList.toggle('close');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
