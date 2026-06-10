@extends('layouts.portal')

@section('title', 'Theme Settings - ' . $organization->name)

@push('styles')
<style>
    .theme-panel { 
        background: var(--card-bg, var(--background-primary)); 
        border-radius: var(--card-radius, var(--border-radius-lg)); 
        box-shadow: var(--card-shadow); 
        border: 1px solid var(--card-border, var(--border-color-light)); 
        padding: 24px; 
        margin-bottom: 24px; 
    }
    .theme-panel-title { 
        font-size: 16px; font-weight: 700; 
        color: var(--text-primary); 
        margin-bottom: 20px; padding-bottom: 12px; 
        border-bottom: 1px solid var(--border-color); 
        display: flex; align-items: center; gap: 8px; 
    }
    .color-input-group { 
        display: flex; flex-direction: column; gap: 6px; 
    }
    .color-input-group label { 
        font-size: 13px; font-weight: 600; 
        color: var(--text-secondary); 
    }
    .color-input-wrapper { 
        display: flex; align-items: center; gap: 8px; 
    }
    .color-input-wrapper input[type="color"] { 
        width: 40px; height: 40px; 
        border: 2px solid var(--border-color); 
        border-radius: var(--border-radius-sm); 
        cursor: pointer; 
        padding: 2px;
        background: none;
    }
    .color-input-wrapper input[type="text"] { 
        flex: 1; padding: 8px 12px; 
        border: 1px solid var(--input-border, #cbd5e1); 
        border-radius: var(--input-radius, var(--border-radius-sm)); 
        font-family: monospace; font-size: 13px; 
        color: var(--text-primary); 
        background: var(--input-bg, var(--background-secondary)); 
    }
    .consent-box {
        background: #fdf8f6;
        border: 1px solid #fbd5c8;
        padding: 16px;
        border-radius: var(--border-radius-md);
        margin-bottom: 24px;
    }
</style>
@endpush

@section('content')
<div class="mb-8">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary);">
                    Theme Settings
                </h1>
                <p class="text-sm mt-0.5" style="color: var(--text-secondary);">
                    Customize the colors and logo for your organization. 
                </p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.theme_settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- COLORS PANEL --}}
            <div class="theme-panel">
                <div class="theme-panel-title">
                    <i class='bx bx-palette' style="color: var(--color-primary);"></i> Brand Colors
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    @foreach([
                        ['primary_color', 'Primary Color', $theme->primary_color ?? $defaults['primary_color']],
                        ['secondary_color', 'Secondary Color', $theme->secondary_color ?? $defaults['secondary_color']],
                        ['accent_color', 'Accent Color', $theme->accent_color ?? $defaults['accent_color']],
                        ['background_primary', 'Background Primary', $theme->background_primary ?? $defaults['background_primary']],
                        ['background_secondary', 'Background Secondary', $theme->background_secondary ?? $defaults['background_secondary']],
                        ['text_primary', 'Text Primary', $theme->text_primary ?? $defaults['text_primary']],
                        ['text_secondary', 'Text Secondary', $theme->text_secondary ?? $defaults['text_secondary']],
                    ] as [$field, $label, $value])
                    <div class="color-input-group">
                        <label for="{{ $field }}">{{ $label }}</label>
                        <div class="color-input-wrapper">
                            <input type="color" id="{{ $field }}_picker" value="{{ $value }}"
                                   onchange="document.getElementById('{{ $field }}').value = this.value;" required>
                            <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ $value }}"
                                   onchange="document.getElementById('{{ $field }}_picker').value = this.value;"
                                   placeholder="#000000" pattern="^#[0-9a-fA-F]{6}$" required>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="theme-panel-title mt-6">
                    <i class='bx bx-adjust' style="color: var(--text-secondary);"></i> Theme Mode
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['light' => 'Light', 'dark' => 'Dark', 'auto' => 'Auto (System)'] as $mode => $label)
                    <label class="flex items-center gap-3 p-4 cursor-pointer transition-all"
                           style="background: var(--background-secondary); border-radius: var(--border-radius-md); border: 2px solid {{ ($theme->theme_mode ?? 'light') === $mode ? 'var(--color-primary)' : 'transparent' }};">
                        <input type="radio" name="theme_mode" value="{{ $mode }}" 
                               {{ ($theme->theme_mode ?? 'light') === $mode ? 'checked' : '' }}
                               class="accent-[var(--color-primary)]">
                        <span class="font-medium text-sm" style="color: var(--text-primary);">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- ASSETS PANEL --}}
            <div class="theme-panel">
                <div class="theme-panel-title">
                    <i class='bx bx-image' style="color: var(--color-primary);"></i> Brand Assets
                </div>
                <div class="grid grid-cols-1 gap-6">
                    @foreach([
                        ['logo_light', 'Logo (Light Background)', $theme->logo_light ?? $organization->logo_url],
                        ['logo_dark', 'Logo (Dark Background)', $theme->logo_dark ?? $organization->logo_url],
                        ['favicon', 'Favicon (16x16 or 32x32)', $theme->favicon],
                    ] as [$field, $label, $currentValue])
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary);">{{ $label }}</label>
                        @if($currentValue)
                        <div class="mb-3 p-3 flex items-center gap-3" 
                             style="background: var(--background-secondary); border-radius: var(--border-radius-md);">
                            <img src="{{ str_starts_with($currentValue, 'http') ? $currentValue : asset('storage/' . $currentValue) }}" 
                                 alt="{{ $label }}" class="h-12 w-auto object-contain">
                        </div>
                        @endif
                        <input type="file" name="{{ $field }}" accept="image/*"
                               class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:cursor-pointer transition-all"
                               style="color: var(--text-secondary);">
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- CONSENT PANEL --}}
        <div class="consent-box flex items-start gap-4">
            <input type="checkbox" name="consent_confirmed" id="consent_confirmed" required 
                   class="mt-1 w-5 h-5 accent-[var(--color-primary)] cursor-pointer">
            <div>
                <label for="consent_confirmed" class="font-bold text-sm text-red-700 cursor-pointer block mb-1">
                    Authorization & Consent Recording
                </label>
                <p class="text-xs text-red-600">
                    I confirm that I have the authorization to change the brand settings for this organization. 
                    I understand that my consent is being recorded (including my ID, IP address, and timestamp) for security and dispute resolution purposes.
                </p>
            </div>
        </div>

        <button type="submit" class="btn-modern px-8">
            <i class='bx bx-save mr-1'></i> Update Theme Settings
        </button>
    </form>
</div>
@endsection
