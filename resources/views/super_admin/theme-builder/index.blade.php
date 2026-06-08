@extends('layouts.portal')

@section('title', 'Theme Builder')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold" style="color: var(--text-primary);">
                <i class='bx bx-palette mr-2' style="color: var(--color-primary);"></i>Theme Builder
            </h1>
            <p class="mt-1" style="color: var(--text-secondary);">Manage white-label themes for all organizations</p>
        </div>
    </div>

    {{-- Preset Gallery --}}
    <div class="mb-8">
        <h2 class="text-lg font-bold mb-4" style="color: var(--text-primary);">
            <i class='bx bx-collection mr-1'></i> Theme Presets
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($presets as $preset)
            <div class="relative overflow-hidden transition-all hover:-translate-y-1"
                 style="background: var(--card-bg, var(--background-primary)); border-radius: var(--card-radius, var(--border-radius-lg)); box-shadow: var(--card-shadow); border: 1px solid var(--card-border, var(--border-color-light));">
                {{-- Color Preview Strip --}}
                <div class="h-20 relative overflow-hidden" style="border-radius: var(--card-radius, var(--border-radius-lg)) var(--card-radius, var(--border-radius-lg)) 0 0;">
                    <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $preset->theme_data['primary_color'] ?? '#2563eb' }} 0%, {{ $preset->theme_data['secondary_color'] ?? '#64748b' }} 60%, {{ $preset->theme_data['accent_color'] ?? '#10b981' }} 100%);"></div>
                    <div class="absolute bottom-2 left-3 flex gap-1">
                        <span class="w-5 h-5 rounded-full border-2 border-white shadow-sm" style="background: {{ $preset->theme_data['primary_color'] ?? '#2563eb' }};"></span>
                        <span class="w-5 h-5 rounded-full border-2 border-white shadow-sm" style="background: {{ $preset->theme_data['secondary_color'] ?? '#64748b' }};"></span>
                        <span class="w-5 h-5 rounded-full border-2 border-white shadow-sm" style="background: {{ $preset->theme_data['accent_color'] ?? '#10b981' }};"></span>
                    </div>
                    @if($preset->is_system)
                    <span class="absolute top-2 right-2 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider rounded-full bg-white/20 text-white backdrop-blur-sm">System</span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-sm" style="color: var(--text-primary);">{{ $preset->name }}</h3>
                    <p class="text-xs mt-1 line-clamp-2" style="color: var(--text-secondary);">{{ $preset->description }}</p>
                    <div class="mt-2 text-xs" style="color: var(--text-tertiary, #94a3b8);">
                        <i class='bx bx-font-family'></i> {{ $preset->theme_data['font_primary'] ?? 'Inter' }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Organization Grid --}}
    <h2 class="text-lg font-bold mb-4" style="color: var(--text-primary);">
        <i class='bx bx-building-house mr-1'></i> Organizations
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($organizations as $org)
        @php
            $orgTheme = $org->activeTheme;
            $primaryColor = $orgTheme->primary_color ?? $org->resolved_primary_color;
            $secondaryColor = $orgTheme->secondary_color ?? $org->resolved_secondary_color;
            $accentColor = $orgTheme->accent_color ?? '#10b981';
            $themeVersion = $orgTheme->theme_version ?? 'N/A';
            $themeName = $orgTheme->theme_name ?? 'Default (Legacy)';
            $publishedAt = $orgTheme->published_at ?? null;
        @endphp
        <div class="relative overflow-hidden transition-all hover:-translate-y-1 hover:shadow-lg"
             style="background: var(--card-bg, var(--background-primary)); border-radius: var(--card-radius, var(--border-radius-lg)); box-shadow: var(--card-shadow); border: 1px solid var(--card-border, var(--border-color-light));">
            
            {{-- Theme Color Header --}}
            <div class="h-24 relative overflow-hidden" style="border-radius: var(--card-radius, var(--border-radius-lg)) var(--card-radius, var(--border-radius-lg)) 0 0;">
                <div class="absolute inset-0" style="background: linear-gradient(135deg, {{ $primaryColor }} 0%, {{ $secondaryColor }} 100%);"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    @if($org->resolved_logo)
                    <img src="{{ $org->resolved_logo }}" alt="{{ $org->name }}" class="h-12 w-auto object-contain bg-white/90 p-2 rounded-lg shadow-md">
                    @else
                    <span class="text-white font-bold text-xl">{{ substr($org->name, 0, 2) }}</span>
                    @endif
                </div>
                <div class="absolute bottom-2 right-3 flex gap-1">
                    <span class="w-4 h-4 rounded-full border-2 border-white/50 shadow-sm" style="background: {{ $primaryColor }};"></span>
                    <span class="w-4 h-4 rounded-full border-2 border-white/50 shadow-sm" style="background: {{ $secondaryColor }};"></span>
                    <span class="w-4 h-4 rounded-full border-2 border-white/50 shadow-sm" style="background: {{ $accentColor }};"></span>
                </div>
            </div>

            {{-- Org Info --}}
            <div class="p-5">
                <h3 class="font-bold text-base mb-1" style="color: var(--text-primary);">{{ $org->name }}</h3>
                <p class="text-xs mb-3" style="color: var(--text-secondary);">
                    <i class='bx bx-globe mr-1'></i>{{ $org->subdomain }}.businzo.com
                </p>

                <div class="flex items-center justify-between mb-3">
                    <div>
                        <span class="text-xs font-medium px-2 py-1 rounded-full" 
                              style="background: var(--background-secondary); color: var(--text-secondary);">
                            {{ $themeName }}
                        </span>
                    </div>
                    <span class="text-xs font-mono" style="color: var(--text-tertiary, #94a3b8);">v{{ $themeVersion }}</span>
                </div>

                @if($publishedAt)
                <p class="text-xs mb-4" style="color: var(--text-tertiary, #94a3b8);">
                    <i class='bx bx-time-five mr-1'></i>Published {{ $publishedAt->diffForHumans() }}
                </p>
                @endif

                <a href="{{ route('super_admin.theme_builder.edit', $org->id) }}" 
                   class="btn-modern btn-sm w-full text-center">
                    <i class='bx bx-edit'></i> Edit Theme
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @if($organizations->isEmpty())
    <div class="text-center py-16" style="color: var(--text-secondary);">
        <i class='bx bx-palette text-6xl mb-4 block' style="color: var(--text-tertiary, #94a3b8);"></i>
        <p class="text-lg font-medium">No approved organizations found</p>
        <p class="text-sm mt-1">Approve organizations from the dashboard to configure their themes.</p>
    </div>
    @endif
</div>
@endsection
