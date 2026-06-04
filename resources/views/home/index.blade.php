<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $activeOrg->name ?? 'Businzo RCMS' }} — Community Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    <style>
        :root {
            --primary: {{ $activeOrg->resolved_primary_color ?? '#4f46e5' }};
            --secondary: {{ $activeOrg->resolved_secondary_color ?? '#1d1b31' }};
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f5f6fa; color: #333; }

        /* ── Header ──────────────────────────── */
        .hero {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            color: #fff; padding: 60px 24px; text-align: center;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        }
        .hero-logo { max-height: 70px; background: rgba(255,255,255,0.95); padding: 8px 20px; border-radius: 12px; margin-bottom: 16px; }
        .hero h1 { font-size: 32px; font-weight: 800; margin-bottom: 8px; position: relative; }
        .hero p { font-size: 16px; opacity: 0.8; position: relative; }
        .hero-nav {
            margin-top: 24px; display: flex; justify-content: center; gap: 12px; flex-wrap: wrap;
            position: relative;
        }
        .hero-nav a {
            color: #fff; text-decoration: none; padding: 8px 20px;
            border: 1px solid rgba(255,255,255,0.3); border-radius: 25px;
            font-size: 13px; font-weight: 500; transition: all 0.3s;
        }
        .hero-nav a:hover { background: rgba(255,255,255,0.15); }
        .hero-nav a.login-btn { background: #fff; color: var(--primary); font-weight: 600; border-color: #fff; }

        /* ── Sections ────────────────────────── */
        .section { max-width: 1100px; margin: 0 auto; padding: 40px 24px; }
        .section-title { font-size: 22px; font-weight: 700; margin-bottom: 20px; color: #333; }

        /* ── Cards Grid ──────────────────────── */
        .cards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 16px; }
        .card {
            background: #fff; border-radius: 12px; padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06); transition: transform 0.2s;
        }
        .card:hover { transform: translateY(-3px); }
        .card h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; color: #333; }
        .card p { font-size: 13px; color: #666; line-height: 1.5; }
        .card .meta { font-size: 12px; color: #999; margin-top: 8px; }

        /* ── Stats ───────────────────────────── */
        .stats { display: flex; gap: 24px; justify-content: center; margin-top: 24px; flex-wrap: wrap; }
        .stat-box {
            background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);
            padding: 16px 32px; border-radius: 12px; text-align: center;
            border: 1px solid rgba(255,255,255,0.15); position: relative;
        }
        .stat-box .number { font-size: 28px; font-weight: 800; }
        .stat-box .label { font-size: 12px; opacity: 0.7; margin-top: 4px; }

        .footer {
            text-align: center; padding: 24px; font-size: 13px; color: #999;
            border-top: 1px solid #eee; margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="hero">
        <img src="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="Logo" class="hero-logo">
        <h1>{{ $activeOrg->name ?? 'Community Portal' }}</h1>
        <p>Residential Community Management System</p>
        <div class="stats">
            <div class="stat-box">
                <div class="number">{{ $members ?? 0 }}</div>
                <div class="label">Members</div>
            </div>
            <div class="stat-box">
                <div class="number">{{ count($events ?? []) }}</div>
                <div class="label">Upcoming Events</div>
            </div>
            <div class="stat-box">
                <div class="number">{{ count($announcements ?? []) }}</div>
                <div class="label">Notices</div>
            </div>
        </div>
        <div class="hero-nav">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('home.events') }}">Events</a>
            <a href="{{ route('home.gallery') }}">Gallery</a>
            <a href="{{ route('home.donors') }}">Donors</a>
            <a href="{{ route('home.sponsors') }}">Sponsors</a>
            <a href="{{ route('home.notices') }}">Notices</a>
            <a href="{{ route('login') }}" class="login-btn">Login</a>
        </div>
    </div>

    @if(count($announcements ?? []) > 0)
    <div class="section">
        <h2 class="section-title"><i class='bx bx-bell'></i> Latest Notices</h2>
        <div class="cards-grid">
            @foreach($announcements as $notice)
            <div class="card">
                <h3>{{ $notice->announcement_subject }}</h3>
                <p>{{ Str::limit($notice->announcement_text, 120) }}</p>
                <div class="meta">{{ $notice->created_at?->format('M d, Y') }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if(count($events ?? []) > 0)
    <div class="section">
        <h2 class="section-title"><i class='bx bx-calendar-event'></i> Upcoming Events</h2>
        <div class="cards-grid">
            @foreach($events as $event)
            <div class="card">
                <h3>{{ $event->title }}</h3>
                <p>{{ Str::limit($event->description, 120) }}</p>
                <div class="meta">{{ $event->event_date?->format('M d, Y') }} {{ $event->event_time ? '• ' . $event->event_time : '' }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="footer">
        &copy; {{ date('Y') }} {{ $activeOrg->name ?? 'Businzo RCMS' }}. Powered by Businzo.
    </div>
</body>
</html>
