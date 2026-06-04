@extends('layouts.auth')

@section('title', 'Register RWA')

@section('content')
<div class="login-glass-card" style="max-width: 520px;">
    <div style="text-align: center; margin-bottom: 1rem;">
        <img src="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="Logo"
             style="max-height: 60px; width: auto; background: rgba(255,255,255,0.95); padding: 8px 16px; border-radius: 8px;">
    </div>
    <p class="subtitle">Register your Resident Welfare Association</p>

    @if($errors->any())
        <div class="glass-alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <p class="subtitle" style="margin-bottom: 12px; font-weight: 600; color: rgba(255,255,255,0.9);">Organization Details</p>
        <div class="glass-input-group">
            <input type="text" name="org_name" placeholder="Organization Name" class="glass-input" required value="{{ old('org_name') }}">
        </div>
        <div class="glass-input-group">
            <input type="text" name="org_address" placeholder="Address" class="glass-input" required value="{{ old('org_address') }}">
        </div>
        <div class="glass-input-group">
            <input type="text" name="registration_code" placeholder="Registration Code" class="glass-input" required value="{{ old('registration_code') }}">
        </div>
        <div class="glass-input-group">
            <input type="text" name="subdomain" placeholder="Subdomain (e.g. myorg)" class="glass-input" required value="{{ old('subdomain') }}">
        </div>

        <p class="subtitle" style="margin-bottom: 12px; margin-top: 20px; font-weight: 600; color: rgba(255,255,255,0.9);">Admin Account</p>
        <div class="glass-input-group">
            <input type="text" name="admin_username" placeholder="Admin Username" class="glass-input" required value="{{ old('admin_username') }}">
        </div>
        <div class="glass-input-group">
            <input type="email" name="admin_email" placeholder="Admin Email" class="glass-input" required value="{{ old('admin_email') }}">
        </div>
        <div class="glass-input-group">
            <input type="password" name="admin_password" placeholder="Password" class="glass-input" required>
        </div>
        <div class="glass-input-group">
            <input type="password" name="admin_password_confirmation" placeholder="Confirm Password" class="glass-input" required>
        </div>

        <button type="submit" class="glass-btn">Register Organization</button>
        <div class="glass-links">
            <a href="{{ route('login') }}">← Already registered? Login</a>
        </div>
    </form>
</div>
@endsection
