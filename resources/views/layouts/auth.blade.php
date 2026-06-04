<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') | {{ $activeOrg->name ?? 'Businzo RCMS' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    <style>
        :root {
            --primary-color: {{ $activeOrg->resolved_primary_color ?? '#4f46e5' }};
            --secondary-color: {{ $activeOrg->resolved_secondary_color ?? '#1d1b31' }};
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, var(--secondary-color) 0%, #2d2b55 50%, var(--primary-color) 100%);
        }
        .login-glass-card {
            background: rgba(255,255,255,0.08); backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.15); border-radius: 20px;
            padding: 40px; width: 100%; max-width: 420px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        }
        .login-glass-card .subtitle {
            color: rgba(255,255,255,0.7); text-align: center;
            font-size: 14px; margin-bottom: 24px;
        }
        .glass-input-group { margin-bottom: 16px; }
        .glass-input {
            width: 100%; padding: 14px 18px; border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px; background: rgba(255,255,255,0.06);
            color: #fff; font-size: 14px; outline: none;
            transition: border-color 0.3s;
        }
        .glass-input::placeholder { color: rgba(255,255,255,0.4); }
        .glass-input:focus { border-color: var(--primary-color); }
        .glass-btn {
            width: 100%; padding: 14px; border: none; border-radius: 12px;
            background: var(--primary-color); color: #fff;
            font-size: 15px; font-weight: 600; cursor: pointer;
            transition: all 0.3s ease; margin-top: 8px;
        }
        .glass-btn:hover { opacity: 0.9; transform: translateY(-1px); }
        .glass-alert {
            background: rgba(231,76,60,0.15); border: 1px solid rgba(231,76,60,0.3);
            color: #ff6b6b; padding: 10px 14px; border-radius: 10px;
            font-size: 13px; margin-bottom: 16px; text-align: center;
        }
        .glass-success {
            background: rgba(39,174,96,0.15); border: 1px solid rgba(39,174,96,0.3);
            color: #6bffb0; padding: 10px 14px; border-radius: 10px;
            font-size: 13px; margin-bottom: 16px; text-align: center;
        }
        .glass-links { text-align: center; margin-top: 16px; }
        .glass-links a { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 13px; }
        .glass-links a:hover { color: #fff; }
    </style>
</head>
<body class="@yield('theme-class', 'theme-member')">
    @yield('content')
</body>
</html>
