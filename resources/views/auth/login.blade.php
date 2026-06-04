@extends('layouts.auth')

@section('title', 'Login')
@section('theme-class', $themeClass ?? 'theme-member')

@section('content')
<div class="login-glass-card">
    <div style="text-align: center; margin-bottom: 1rem;">
        <img src="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="Organization Logo"
             style="max-height: 80px; width: auto; object-fit: contain; background: rgba(255,255,255,0.95); padding: 8px 16px; border-radius: 8px;">
    </div>
    <p class="subtitle">Log in to the Community Management Portal</p>

    @if(session('success'))
        <div class="glass-success">{{ session('success') }}</div>
    @endif

    @if($errors->has('login'))
        <div class="glass-alert">{{ $errors->first('login') }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="glass-input-group">
            <input type="text" name="username" placeholder="Username" class="glass-input"
                   required autocomplete="username" value="{{ old('username') }}">
        </div>
        <div class="glass-input-group">
            <input type="password" name="password" placeholder="Password" class="glass-input"
                   required autocomplete="current-password">
        </div>
        <button type="submit" class="glass-btn">Log In</button>
        <div class="glass-links">
            <a href="{{ route('home') }}">← Back To Home</a>
            &nbsp;|&nbsp;
            <a href="{{ route('register') }}">Register RWA</a>
        </div>
    </form>
</div>
@endsection
