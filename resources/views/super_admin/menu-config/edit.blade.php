@extends('layouts.portal')
@section('title', 'Configure Menus — ' . $organization->name)

@push('styles')
<style>
    .config-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
        transition: color 0.2s;
    }
    .config-back:hover { color: var(--primary-color); text-decoration: none; }

    .org-header-card {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 20px;
        color: #fff;
        box-shadow: 0 10px 25px -5px rgba(30,27,75,0.3);
    }
    .org-header-avatar {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 800;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
    }
    .org-header-info h2 {
        font-size: 22px;
        font-weight: 800;
        margin: 0;
    }
    .org-header-info .sub {
        font-size: 14px;
        color: rgba(255,255,255,0.6);
        margin-top: 4px;
    }
    .org-header-badges {
        display: flex;
        gap: 8px;
        margin-top: 8px;
    }
    .header-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.9);
    }

    /* Sections */
    .config-section {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .config-section-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .config-section-header h3 {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .config-section-header h3 i {
        color: var(--primary-color);
    }
    .config-section-body {
        padding: 24px 28px;
    }

    /* Meta Fields */
    .meta-fields {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .meta-field label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .meta-field input,
    .meta-field select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        color: #334155;
        background: #f8fafc;
        transition: all 0.2s;
    }
    .meta-field input:focus,
    .meta-field select:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        background: #fff;
    }

    /* Preset hint */
    .preset-hint {
        display: none;
        margin-top: 12px;
        padding: 14px 18px;
        background: #fef3c7;
        border: 1px solid #fde68a;
        border-radius: 12px;
        font-size: 13px;
        color: #92400e;
        animation: fadeInDown 0.3s ease;
    }
    .preset-hint.show { display: flex; align-items: center; gap: 10px; }
    .preset-hint i { font-size: 18px; }
    .preset-hint button {
        margin-left: auto;
        padding: 6px 14px;
        border-radius: 8px;
        border: none;
        background: #d97706;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }
    .preset-hint button:hover { background: #b45309; }

    /* Menu Toggle Grid */
    .menu-group-title {
        font-size: 13px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin: 24px 0 12px 0;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f5f9;
    }
    .menu-group-title:first-child { margin-top: 0; }

    .menu-toggle-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 12px;
    }
    .menu-toggle-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 18px;
        border-radius: 14px;
        border: 1px solid #f1f5f9;
        background: #fafbfc;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .menu-toggle-card:hover {
        border-color: #e2e8f0;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .menu-toggle-card.enabled {
        border-color: rgba(79,70,229,0.2);
        background: rgba(79,70,229,0.03);
    }
    .menu-toggle-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        background: #f1f5f9;
        color: #64748b;
        flex-shrink: 0;
        transition: all 0.25s;
    }
    .menu-toggle-card.enabled .menu-toggle-icon {
        background: linear-gradient(135deg, var(--primary-color), #8b5cf6);
        color: #fff;
        box-shadow: 0 4px 10px rgba(79,70,229,0.2);
    }
    .menu-toggle-info {
        flex: 1;
        min-width: 0;
    }
    .menu-toggle-info .toggle-label {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
    }
    .menu-toggle-info .toggle-desc {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        width: 48px;
        height: 26px;
        flex-shrink: 0;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #cbd5e1;
        border-radius: 26px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background: white;
        border-radius: 50%;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .toggle-switch input:checked + .toggle-slider {
        background: linear-gradient(135deg, var(--primary-color), #7c3aed);
    }
    .toggle-switch input:checked + .toggle-slider:before {
        transform: translateX(22px);
    }

    /* Master toggle */
    .master-toggle-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 18px;
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    .master-toggle-bar span {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
    }
    .master-toggle-actions {
        display: flex;
        gap: 8px;
    }
    .master-toggle-actions button {
        padding: 6px 14px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #fff;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
    }
    .master-toggle-actions button:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    /* Save bar */
    .save-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 28px;
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
    }
    .save-bar .counter {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
    }
    .save-bar .counter strong {
        color: var(--primary-color);
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .meta-fields { grid-template-columns: 1fr; }
        .menu-toggle-grid { grid-template-columns: 1fr; }
        .org-header-card { flex-direction: column; text-align: center; }
    }
</style>
@endpush

@section('content')
<a href="{{ route('super_admin.menu_config.index') }}" class="config-back">
    <i class='bx bx-arrow-back'></i> Back to Menu Configuration
</a>

<!-- Organization Header -->
<div class="org-header-card">
    <div class="org-header-avatar">{{ strtoupper(substr($organization->name, 0, 2)) }}</div>
    <div class="org-header-info">
        <h2>{{ $organization->name }}</h2>
        <div class="sub">{{ $organization->subdomain }}.rcms.businzo.com</div>
        <div class="org-header-badges">
            <span class="header-badge">{{ ucfirst($organization->status) }}</span>
            @if($organization->residential_type)
                <span class="header-badge">{{ str_replace('_', ' ', $organization->residential_type) }}</span>
            @endif
            @if($organization->location)
                <span class="header-badge"><i class='bx bx-map'></i> {{ $organization->location }}</span>
            @endif
        </div>
    </div>
</div>

<form action="{{ route('super_admin.menu_config.update', $organization->id) }}" method="POST" id="menuConfigForm">
    @csrf
    @method('PUT')

    <!-- Location & Type Section -->
    <div class="config-section">
        <div class="config-section-header">
            <h3><i class='bx bx-map-pin'></i> Location & Residential Type</h3>
        </div>
        <div class="config-section-body">
            <div class="meta-fields">
                <div class="meta-field">
                    <label for="location">Location / Area</label>
                    <input type="text" id="location" name="location"
                           value="{{ old('location', $organization->location) }}"
                           placeholder="e.g. Whitefield, Bangalore">
                </div>
                <div class="meta-field">
                    <label for="residential_type">Residential Type</label>
                    <select id="residential_type" name="residential_type">
                        <option value="">— Select Type —</option>
                        @foreach($residentialTypes as $key => $preset)
                            <option value="{{ $key }}"
                                {{ old('residential_type', $organization->residential_type) === $key ? 'selected' : '' }}
                                data-desc="{{ $preset['description'] }}">
                                {{ $preset['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="preset-hint" id="presetHint">
                <i class='bx bx-bulb'></i>
                <span id="presetHintText">A preset is available for this type. Apply it?</span>
                <button type="button" id="applyPresetBtn" onclick="applyPreset()">Apply Preset</button>
            </div>
        </div>
    </div>

    <!-- Menu Configuration Section -->
    <div class="config-section">
        <div class="config-section-header">
            <h3><i class='bx bx-menu-alt-left'></i> Admin Menu Items</h3>
            <span style="font-size: 13px; color: #94a3b8;">Dashboard is always enabled</span>
        </div>
        <div class="config-section-body">
            <div class="master-toggle-bar">
                <span id="selectedCount">{{ count($enabledMenus) }} of {{ count($menuItems) }} menus enabled</span>
                <div class="master-toggle-actions">
                    <button type="button" onclick="toggleAll(true)">Enable All</button>
                    <button type="button" onclick="toggleAll(false)">Disable All</button>
                </div>
            </div>

            @php
                $grouped = [];
                foreach($menuItems as $key => $item) {
                    $grouped[$item['group']][$key] = $item;
                }
            @endphp

            @foreach($grouped as $groupName => $items)
                <div class="menu-group-title">{{ $groupName }}</div>
                <div class="menu-toggle-grid">
                    @foreach($items as $key => $item)
                    @php $isEnabled = in_array($key, $enabledMenus); @endphp
                    <label class="menu-toggle-card {{ $isEnabled ? 'enabled' : '' }}" id="card-{{ str_replace('.', '-', $key) }}" for="toggle-{{ str_replace('.', '-', $key) }}">
                        <div class="menu-toggle-icon">
                            <i class='bx {{ $item['icon'] }}'></i>
                        </div>
                        <div class="menu-toggle-info">
                            <div class="toggle-label">{{ $item['label'] }}</div>
                            <div class="toggle-desc">{{ $item['description'] }}</div>
                        </div>
                        <div class="toggle-switch">
                            <input type="checkbox"
                                   id="toggle-{{ str_replace('.', '-', $key) }}"
                                   name="enabled_menus[]"
                                   value="{{ $key }}"
                                   {{ $isEnabled ? 'checked' : '' }}
                                   onchange="updateToggleCard(this, '{{ str_replace('.', '-', $key) }}')">
                            <span class="toggle-slider"></span>
                        </div>
                    </label>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    <!-- Save Bar -->
    <div class="save-bar">
        <div class="counter">
            <strong id="enabledCountDisplay">{{ count($enabledMenus) }}</strong> / {{ count($menuItems) }} menus will be shown to RWA Admin
        </div>
        <button type="submit" class="btn-modern">
            <i class='bx bx-save'></i> Save Configuration
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    const totalMenus = {{ count($menuItems) }};
    const presetRoute = "{{ url('/super-admin/menu-config/presets') }}";

    // Update card visual state on toggle
    function updateToggleCard(checkbox, key) {
        const card = document.getElementById('card-' + key);
        if (checkbox.checked) {
            card.classList.add('enabled');
        } else {
            card.classList.remove('enabled');
        }
        updateCount();
    }

    // Count enabled menus
    function updateCount() {
        const checked = document.querySelectorAll('input[name="enabled_menus[]"]:checked').length;
        document.getElementById('selectedCount').textContent = checked + ' of ' + totalMenus + ' menus enabled';
        document.getElementById('enabledCountDisplay').textContent = checked;
    }

    // Toggle all on/off
    function toggleAll(enable) {
        document.querySelectorAll('input[name="enabled_menus[]"]').forEach(cb => {
            cb.checked = enable;
            updateToggleCard(cb, cb.id.replace('toggle-', ''));
        });
        updateCount();
    }

    // Residential type change — show preset hint
    document.getElementById('residential_type').addEventListener('change', function() {
        const type = this.value;
        const hint = document.getElementById('presetHint');
        if (type) {
            hint.classList.add('show');
            const option = this.options[this.selectedIndex];
            document.getElementById('presetHintText').textContent =
                'A recommended preset is available for "' + option.text + '". Apply it to auto-configure menus?';
        } else {
            hint.classList.remove('show');
        }
    });

    // Apply preset via AJAX
    function applyPreset() {
        const type = document.getElementById('residential_type').value;
        if (!type) return;

        fetch(presetRoute + '/' + type)
            .then(r => r.json())
            .then(data => {
                // First disable all
                document.querySelectorAll('input[name="enabled_menus[]"]').forEach(cb => {
                    cb.checked = false;
                    updateToggleCard(cb, cb.id.replace('toggle-', ''));
                });
                // Enable preset menus
                data.menus.forEach(key => {
                    const idSafeKey = key.replace(/\./g, '-');
                    const cb = document.getElementById('toggle-' + idSafeKey);
                    if (cb) {
                        cb.checked = true;
                        updateToggleCard(cb, idSafeKey);
                    }
                });
                updateCount();
                document.getElementById('presetHint').classList.remove('show');
            })
            .catch(err => console.error('Failed to load preset:', err));
    }
</script>
@endpush
