@extends('layouts.portal')

@section('title', 'Edit Theme - ' . $organization->name)

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
    .select-modern { 
        width: 100%; padding: 10px 14px; 
        border: 1px solid var(--input-border, #cbd5e1); 
        border-radius: var(--input-radius, var(--border-radius-sm)); 
        font-size: 14px; 
        color: var(--text-primary); 
        background: var(--input-bg, var(--background-secondary)); 
        cursor: pointer; 
    }
    .preview-frame { 
        background: var(--background-secondary); 
        border-radius: var(--border-radius-lg); 
        border: 1px solid var(--border-color); 
        overflow: hidden; 
        min-height: 300px; 
    }
    .preview-navbar { 
        padding: 12px 20px; display: flex; 
        align-items: center; justify-content: space-between; 
    }
    .preview-sidebar { 
        width: 60px; min-height: 250px; 
        display: flex; flex-direction: column; 
        align-items: center; gap: 12px; 
        padding: 16px 8px; 
    }
    .preview-dot { 
        width: 32px; height: 32px; 
        border-radius: 8px; 
        opacity: 0.3; 
    }
    .preview-card { 
        padding: 16px; margin: 8px; 
    }
    .preset-card { 
        cursor: pointer; transition: all 0.3s; 
        border: 2px solid transparent; 
    }
    .preset-card:hover { 
        border-color: var(--color-primary); 
        transform: translateY(-2px); 
    }
    .tab-btn { 
        padding: 10px 20px; 
        font-size: 14px; font-weight: 600; 
        border: none; cursor: pointer; 
        background: transparent; 
        color: var(--text-secondary); 
        border-bottom: 2px solid transparent; 
        transition: all 0.2s; 
    }
    .tab-btn.active { 
        color: var(--color-primary); 
        border-bottom-color: var(--color-primary); 
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .custom-css-editor {
        width: 100%; min-height: 200px;
        font-family: 'Fira Code', 'Consolas', monospace;
        font-size: 13px; line-height: 1.6;
        padding: 16px;
        border: 1px solid var(--input-border, #cbd5e1);
        border-radius: var(--input-radius, var(--border-radius-md));
        background: var(--background-primary);
        color: var(--text-primary);
        resize: vertical;
        tab-size: 2;
    }
</style>
@endpush

@section('content')
<div class="mb-8">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('super_admin.theme_builder.index') }}" 
               class="w-10 h-10 flex items-center justify-center rounded-full transition-all hover:-translate-x-1"
               style="background: var(--background-secondary); color: var(--text-secondary);">
                <i class='bx bx-arrow-back text-xl'></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary);">
                    {{ $organization->name }}
                </h1>
                <p class="text-sm mt-0.5" style="color: var(--text-secondary);">
                    Theme: <strong>{{ $theme->theme_name ?? 'Default' }}</strong> 
                    <span class="font-mono text-xs ml-2">v{{ $theme->theme_version ?? '0.0.0' }}</span>
                </p>
            </div>
        </div>
        <div class="flex gap-3">
            <form action="{{ route('super_admin.theme_builder.publish', $organization->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-modern btn-success btn-sm">
                    <i class='bx bx-check-circle'></i> Publish
                </button>
            </form>
            <form action="{{ route('super_admin.theme_builder.rollback', $organization->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Are you sure you want to rollback to the previous theme version?')">
                @csrf
                <button type="submit" class="btn-modern btn-outline btn-sm">
                    <i class='bx bx-undo'></i> Rollback
                </button>
            </form>
        </div>
    </div>

    <form action="{{ route('super_admin.theme_builder.store', $organization->id) }}" method="POST" enctype="multipart/form-data" id="themeForm">
        @csrf

        {{-- Tab Navigation --}}
        <div class="flex border-b mb-6" style="border-color: var(--border-color);">
            <button type="button" class="tab-btn active" data-tab="colors">
                <i class='bx bx-palette mr-1'></i> Colors
            </button>
            <button type="button" class="tab-btn" data-tab="typography">
                <i class='bx bx-font-family mr-1'></i> Typography
            </button>
            <button type="button" class="tab-btn" data-tab="spacing">
                <i class='bx bx-border-radius mr-1'></i> Spacing
            </button>
            <button type="button" class="tab-btn" data-tab="assets">
                <i class='bx bx-image mr-1'></i> Assets
            </button>
            <button type="button" class="tab-btn" data-tab="components">
                <i class='bx bx-code-alt mr-1'></i> Components
            </button>
            <button type="button" class="tab-btn" data-tab="custom-css">
                <i class='bx bx-code-curly mr-1'></i> Custom CSS
            </button>
            <button type="button" class="tab-btn" data-tab="presets">
                <i class='bx bx-collection mr-1'></i> Presets
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Settings Panels --}}
            <div class="lg:col-span-2">
                
                {{-- COLORS TAB --}}
                <div class="tab-content active" id="tab-colors">
                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-sun' style="color: var(--color-primary);"></i> Light Mode Colors
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            @foreach([
                                ['primary_color', 'Primary Color', $theme->primary_color ?? $defaults['primary_color']],
                                ['secondary_color', 'Secondary Color', $theme->secondary_color ?? $defaults['secondary_color']],
                                ['accent_color', 'Accent Color', $theme->accent_color ?? $defaults['accent_color']],
                                ['background_primary', 'Background', $theme->background_primary ?? $defaults['background_primary']],
                                ['background_secondary', 'Surface', $theme->background_secondary ?? $defaults['background_secondary']],
                                ['text_primary', 'Text Primary', $theme->text_primary ?? $defaults['text_primary']],
                                ['text_secondary', 'Text Secondary', $theme->text_secondary ?? $defaults['text_secondary']],
                            ] as [$field, $label, $value])
                            <div class="color-input-group">
                                <label for="{{ $field }}">{{ $label }}</label>
                                <div class="color-input-wrapper">
                                    <input type="color" id="{{ $field }}_picker" value="{{ $value }}"
                                           onchange="document.getElementById('{{ $field }}').value = this.value; updatePreview();">
                                    <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ $value }}"
                                           onchange="document.getElementById('{{ $field }}_picker').value = this.value; updatePreview();"
                                           placeholder="#000000" pattern="^#[0-9a-fA-F]{6}$">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-moon' style="color: var(--color-accent);"></i> Dark Mode Colors
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @foreach([
                                ['dark_bg_primary', 'Dark Background', $theme->dark_bg_primary ?? '#0f172a'],
                                ['dark_bg_secondary', 'Dark Surface', $theme->dark_bg_secondary ?? '#1e293b'],
                                ['dark_text_primary', 'Dark Text Primary', $theme->dark_text_primary ?? '#f1f5f9'],
                                ['dark_text_secondary', 'Dark Text Secondary', $theme->dark_text_secondary ?? '#94a3b8'],
                            ] as [$field, $label, $value])
                            <div class="color-input-group">
                                <label for="{{ $field }}">{{ $label }}</label>
                                <div class="color-input-wrapper">
                                    <input type="color" id="{{ $field }}_picker" value="{{ $value }}"
                                           onchange="document.getElementById('{{ $field }}').value = this.value;">
                                    <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ $value }}"
                                           onchange="document.getElementById('{{ $field }}_picker').value = this.value;"
                                           placeholder="#000000">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-adjust'></i> Theme Mode
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach(['light' => 'Light', 'dark' => 'Dark', 'auto' => 'Auto (System)', 'custom' => 'Custom'] as $mode => $label)
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
                </div>

                {{-- TYPOGRAPHY TAB --}}
                <div class="tab-content" id="tab-typography">
                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-font-family' style="color: var(--color-primary);"></i> Fonts
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary);">Primary Font</label>
                                <select name="font_primary" class="select-modern" id="font_primary" onchange="updatePreview();">
                                    @foreach($allowedFonts as $font)
                                    <option value="{{ $font }}" {{ ($theme->font_primary ?? 'Inter') === $font ? 'selected' : '' }}
                                            style="font-family: '{{ $font }}', sans-serif;">
                                        {{ $font }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary);">Secondary Font</label>
                                <select name="font_secondary" class="select-modern" id="font_secondary">
                                    @foreach($allowedFonts as $font)
                                    <option value="{{ $font }}" {{ ($theme->font_secondary ?? 'Poppins') === $font ? 'selected' : '' }}>
                                        {{ $font }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-5">
                            <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary);">Base Font Size</label>
                            <div class="flex items-center gap-4">
                                <input type="range" min="12" max="20" value="{{ intval($theme->font_size_base ?? '15') }}" 
                                       class="flex-1" id="font_size_range"
                                       oninput="document.getElementById('font_size_base').value = this.value + 'px'; document.getElementById('font_size_display').textContent = this.value + 'px';">
                                <span id="font_size_display" class="font-mono text-sm" style="color: var(--text-primary);">{{ $theme->font_size_base ?? '15px' }}</span>
                                <input type="hidden" name="font_size_base" id="font_size_base" value="{{ $theme->font_size_base ?? '15px' }}">
                            </div>
                        </div>

                        {{-- Font Preview --}}
                        <div class="mt-6 p-5" style="background: var(--background-secondary); border-radius: var(--border-radius-md);">
                            <p class="font-bold text-lg mb-2" style="color: var(--text-primary);" id="fontPreviewHeading">
                                The quick brown fox jumps over the lazy dog
                            </p>
                            <p class="text-sm" style="color: var(--text-secondary);">
                                ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz 0123456789
                            </p>
                        </div>
                    </div>
                </div>

                {{-- SPACING TAB --}}
                <div class="tab-content" id="tab-spacing">
                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-border-radius' style="color: var(--color-primary);"></i> Border Radius
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            @foreach([
                                ['border_radius_sm', 'Small', $theme->border_radius_sm ?? '6px'],
                                ['border_radius_md', 'Medium', $theme->border_radius_md ?? '10px'],
                                ['border_radius_lg', 'Large', $theme->border_radius_lg ?? '16px'],
                            ] as [$field, $label, $value])
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary);">{{ $label }}</label>
                                <div class="flex items-center gap-3">
                                    <input type="range" min="0" max="30" value="{{ intval($value) }}" 
                                           class="flex-1"
                                           oninput="document.getElementById('{{ $field }}').value = this.value + 'px'; document.getElementById('{{ $field }}_preview').style.borderRadius = this.value + 'px'; document.getElementById('{{ $field }}_val').textContent = this.value + 'px';">
                                    <span id="{{ $field }}_val" class="font-mono text-xs w-12 text-right" style="color: var(--text-primary);">{{ $value }}</span>
                                    <input type="hidden" name="{{ $field }}" id="{{ $field }}" value="{{ $value }}">
                                </div>
                                <div id="{{ $field }}_preview" class="w-16 h-16 mt-3 transition-all"
                                     style="background: var(--color-primary); border-radius: {{ $value }}; opacity: 0.7;"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ASSETS TAB --}}
                <div class="tab-content" id="tab-assets">
                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-image' style="color: var(--color-primary);"></i> Brand Assets
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach([
                                ['logo_light', 'Logo (Light Background)', $theme->logo_light],
                                ['logo_dark', 'Logo (Dark Background)', $theme->logo_dark],
                                ['favicon', 'Favicon', $theme->favicon],
                            ] as [$field, $label, $currentValue])
                            <div>
                                <label class="block text-sm font-semibold mb-2" style="color: var(--text-secondary);">{{ $label }}</label>
                                @if($currentValue)
                                <div class="mb-3 p-3 flex items-center gap-3" 
                                     style="background: var(--background-secondary); border-radius: var(--border-radius-md);">
                                    <img src="{{ str_starts_with($currentValue, 'http') ? $currentValue : asset('storage/' . $currentValue) }}" 
                                         alt="{{ $label }}" class="h-12 w-auto object-contain">
                                    <span class="text-xs truncate" style="color: var(--text-secondary);">{{ basename($currentValue) }}</span>
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

                {{-- COMPONENTS TAB --}}
                <div class="tab-content" id="tab-components">
                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-code-alt' style="color: var(--color-primary);"></i> Component Token Overrides
                        </div>
                        <p class="text-sm mb-4" style="color: var(--text-secondary);">
                            Override default styles for specific components. Values use CSS syntax.
                        </p>
                        <textarea name="component_tokens" id="component_tokens" rows="16" 
                                  class="custom-css-editor"
                                  placeholder='{ "button": { "border-radius": "20px" }, "card": { "shadow": "none" } }'>{{ json_encode($theme->component_tokens ?? new \stdClass, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</textarea>
                        <p class="text-xs mt-2" style="color: var(--text-tertiary, #94a3b8);">
                            <i class='bx bx-info-circle mr-1'></i> 
                            Supported components: button, card, sidebar, navbar, input, table, modal, badge
                        </p>
                    </div>
                </div>

                {{-- CUSTOM CSS TAB --}}
                <div class="tab-content" id="tab-custom-css">
                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-code-curly' style="color: var(--color-primary);"></i> Custom CSS
                        </div>
                        <p class="text-sm mb-4" style="color: var(--text-secondary);">
                            Add tenant-specific CSS rules. Max {{ config('theme.custom_css_max_size', 50000) / 1000 }}KB. 
                            Dangerous directives (@import, external url(), javascript:) are automatically stripped.
                        </p>
                        <textarea name="custom_css" id="custom_css" rows="16"
                                  class="custom-css-editor"
                                  placeholder=".custom-button { text-transform: uppercase; }">{{ $theme->custom_css ?? '' }}</textarea>
                    </div>
                </div>

                {{-- PRESETS TAB --}}
                <div class="tab-content" id="tab-presets">
                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-collection' style="color: var(--color-primary);"></i> Apply a Preset
                        </div>
                        <p class="text-sm mb-5" style="color: var(--text-secondary);">
                            Choose a preset as a starting point. Your existing customizations will be overwritten.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($presets as $preset)
                            <div class="preset-card overflow-hidden"
                                 style="background: var(--card-bg); border-radius: var(--card-radius, var(--border-radius-lg)); box-shadow: var(--shadow-sm); border: 1px solid var(--border-color-light);">
                                <div class="h-16" style="background: linear-gradient(135deg, {{ $preset->theme_data['primary_color'] ?? '#2563eb' }}, {{ $preset->theme_data['secondary_color'] ?? '#64748b' }});"></div>
                                <div class="p-4">
                                    <h4 class="font-bold text-sm" style="color: var(--text-primary);">{{ $preset->name }}</h4>
                                    <p class="text-xs mt-1 mb-3" style="color: var(--text-secondary);">{{ Str::limit($preset->description, 80) }}</p>
                                    <form action="{{ route('super_admin.theme_builder.apply_preset', $organization->id) }}" method="POST"
                                          onsubmit="return confirm('Apply the {{ $preset->name }} preset? This will overwrite current theme settings.');">
                                        @csrf
                                        <input type="hidden" name="preset_id" value="{{ $preset->id }}">
                                        <button type="submit" class="btn-modern btn-outline btn-sm w-full">
                                            <i class='bx bx-check'></i> Apply
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Live Preview --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="theme-panel">
                        <div class="theme-panel-title">
                            <i class='bx bx-show' style="color: var(--color-primary);"></i> Live Preview
                        </div>

                        {{-- Mini Preview --}}
                        <div class="preview-frame" id="previewFrame">
                            {{-- Preview Navbar --}}
                            <div class="preview-navbar" id="preview-navbar" 
                                 style="background: var(--navbar-bg); border-bottom: 1px solid var(--border-color-light);">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold" 
                                         id="preview-logo-bg" style="background: var(--color-primary);">
                                        {{ substr($organization->name, 0, 2) }}
                                    </div>
                                    <span class="text-xs font-bold" id="preview-org-name" style="color: var(--text-primary);">{{ Str::limit($organization->name, 15) }}</span>
                                </div>
                                <div class="flex gap-1">
                                    <div class="w-12 h-6 rounded text-xs flex items-center justify-center text-white font-bold"
                                         id="preview-btn" style="background: var(--color-primary); border-radius: var(--border-radius-sm); font-size: 10px;">
                                        Login
                                    </div>
                                </div>
                            </div>

                            <div class="flex">
                                {{-- Preview Sidebar --}}
                                <div class="preview-sidebar" id="preview-sidebar" style="background: var(--sidebar-bg);">
                                    <div class="preview-dot" style="background: white;"></div>
                                    <div class="preview-dot" id="preview-sidebar-active" style="background: var(--color-primary); opacity: 1;"></div>
                                    <div class="preview-dot" style="background: white;"></div>
                                    <div class="preview-dot" style="background: white;"></div>
                                    <div class="preview-dot" style="background: white;"></div>
                                </div>

                                {{-- Preview Content --}}
                                <div class="flex-1 p-3" style="background: var(--background-secondary);">
                                    {{-- Stats Cards --}}
                                    <div class="grid grid-cols-2 gap-2 mb-3">
                                        <div class="preview-card" id="preview-card-1"
                                             style="background: var(--card-bg, white); border-radius: var(--border-radius-md); box-shadow: var(--shadow-sm);">
                                            <div class="text-[10px] font-bold" style="color: var(--text-secondary);">MEMBERS</div>
                                            <div class="text-lg font-extrabold" style="color: var(--text-primary);">124</div>
                                        </div>
                                        <div class="preview-card"
                                             style="background: var(--card-bg, white); border-radius: var(--border-radius-md); box-shadow: var(--shadow-sm);">
                                            <div class="text-[10px] font-bold" style="color: var(--text-secondary);">EVENTS</div>
                                            <div class="text-lg font-extrabold" style="color: var(--text-primary);">8</div>
                                        </div>
                                    </div>
                                    {{-- Button Preview --}}
                                    <div class="flex gap-2 mb-3">
                                        <div class="px-3 py-1.5 text-[10px] font-bold text-white" id="preview-btn-primary"
                                             style="background: var(--color-primary); border-radius: var(--button-radius, var(--border-radius-md));">
                                            Primary
                                        </div>
                                        <div class="px-3 py-1.5 text-[10px] font-bold border"
                                             style="color: var(--color-primary); border-color: var(--color-primary); border-radius: var(--button-radius, var(--border-radius-md));">
                                            Outline
                                        </div>
                                        <div class="px-3 py-1.5 text-[10px] font-bold text-white"
                                             style="background: var(--color-accent); border-radius: var(--button-radius, var(--border-radius-md));">
                                            Accent
                                        </div>
                                    </div>
                                    {{-- Table Preview --}}
                                    <div style="background: var(--card-bg, white); border-radius: var(--border-radius-md); overflow: hidden;">
                                        <div class="flex text-[9px] font-bold px-3 py-2"
                                             style="background: var(--table-header-bg, var(--background-secondary)); color: var(--table-header-text, var(--text-secondary));">
                                            <span class="flex-1">NAME</span><span class="w-16">STATUS</span>
                                        </div>
                                        <div class="flex text-[10px] px-3 py-2" style="color: var(--text-primary); border-bottom: 1px solid var(--border-color-light);">
                                            <span class="flex-1">John Doe</span>
                                            <span class="px-2 py-0.5 text-[8px] font-bold rounded-full bg-green-100 text-green-700">Active</span>
                                        </div>
                                        <div class="flex text-[10px] px-3 py-2" style="color: var(--text-primary);">
                                            <span class="flex-1">Jane Smith</span>
                                            <span class="px-2 py-0.5 text-[8px] font-bold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <button type="submit" class="btn-modern w-full text-center">
                        <i class='bx bx-save mr-1'></i> Save Theme
                    </button>

                    {{-- Theme Meta --}}
                    <div class="mt-4 p-4" style="background: var(--background-secondary); border-radius: var(--border-radius-md);">
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span style="color: var(--text-secondary);">Version</span>
                            <span class="font-mono font-bold" style="color: var(--text-primary);">{{ $theme->theme_version ?? '0.0.0' }}</span>
                        </div>
                        @if($theme->published_at)
                        <div class="flex items-center justify-between text-xs mb-2">
                            <span style="color: var(--text-secondary);">Published</span>
                            <span style="color: var(--text-primary);">{{ $theme->published_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between text-xs">
                            <span style="color: var(--text-secondary);">Mode</span>
                            <span class="capitalize font-medium" style="color: var(--text-primary);">{{ $theme->theme_mode ?? 'Light' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="theme_name" value="{{ $theme->theme_name ?? $organization->name . ' Theme' }}">
    </form>
</div>

@endsection

@push('scripts')
<script>
    // Tab switching
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
        });
    });

    // Live preview updates
    function updatePreview() {
        const frame = document.getElementById('previewFrame');
        if (!frame) return;

        const getVal = id => document.getElementById(id)?.value;

        // Update CSS variables on the preview frame
        const vars = {
            '--color-primary': getVal('primary_color'),
            '--color-secondary': getVal('secondary_color'),
            '--color-accent': getVal('accent_color'),
            '--background-primary': getVal('background_primary'),
            '--background-secondary': getVal('background_secondary'),
            '--text-primary': getVal('text_primary'),
            '--text-secondary': getVal('text_secondary'),
        };

        Object.entries(vars).forEach(([prop, val]) => {
            if (val) frame.style.setProperty(prop, val);
        });

        // Update elements that use inline styles
        const primary = getVal('primary_color');
        const secondary = getVal('secondary_color');
        const accent = getVal('accent_color');

        if (primary) {
            document.querySelectorAll('#previewFrame [id*="preview-btn"], #preview-logo-bg, #preview-sidebar-active').forEach(el => {
                el.style.background = primary;
            });
        }
        if (secondary) {
            document.getElementById('preview-sidebar').style.background = secondary;
        }

        // Font preview
        const font = document.getElementById('font_primary')?.value;
        if (font) {
            const heading = document.getElementById('fontPreviewHeading');
            if (heading) heading.style.fontFamily = `'${font}', sans-serif`;
        }
    }

    // Bind color inputs
    document.querySelectorAll('input[type="color"], input[type="text"][id$="_color"], input[type="text"][id^="background_"], input[type="text"][id^="text_"]').forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });
</script>
@endpush
