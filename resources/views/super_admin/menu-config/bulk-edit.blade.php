@extends('layouts.portal')
@section('title', 'Bulk Menu Configuration')

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

    .bulk-header-card {
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        border-radius: 20px;
        padding: 28px 32px;
        margin-bottom: 28px;
        color: #fff;
        box-shadow: 0 10px 25px -5px rgba(30,27,75,0.3);
    }
    .bulk-header-info h2 {
        font-size: 22px;
        font-weight: 800;
        margin: 0;
    }
    .bulk-header-info .sub {
        font-size: 14px;
        color: rgba(255,255,255,0.6);
        margin-top: 4px;
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
    .meta-field select:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
        background: #fff;
    }

    /* Organization Selection */
    .org-selection-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 12px;
        max-height: 300px;
        overflow-y: auto;
        padding-right: 10px;
        margin-bottom: 16px;
    }
    .org-toggle-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #fafbfc;
        cursor: pointer;
        transition: all 0.2s;
    }
    .org-toggle-card:hover { background: #fff; border-color: #cbd5e1; }
    .org-toggle-card.selected { border-color: var(--primary-color); background: rgba(79,70,229,0.03); }
    .org-toggle-card input[type="checkbox"] {
        width: 18px; height: 18px; cursor: pointer;
    }
    .org-toggle-info { font-size: 14px; font-weight: 600; color: #1e293b; }

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
</style>
@endpush

@section('content')
<a href="{{ route('super_admin.menu_config.index') }}" class="config-back">
    <i class='bx bx-arrow-back'></i> Back to Menu Configuration
</a>

<!-- Header -->
<div class="bulk-header-card">
    <div class="bulk-header-info">
        <h2>Bulk Edit Menu Configurations</h2>
        <div class="sub">Apply standard menu templates across multiple organizations simultaneously.</div>
    </div>
</div>

<form action="{{ route('super_admin.menu_config.bulk_update') }}" method="POST" id="bulkMenuConfigForm">
    @csrf

    <!-- Target Organizations Section -->
    <div class="config-section">
        <div class="config-section-header">
            <h3><i class='bx bx-buildings'></i> Select Organizations</h3>
        </div>
        <div class="config-section-body">
            <div class="master-toggle-bar">
                <span id="orgSelectedCount">0 organizations selected</span>
                <div class="master-toggle-actions">
                    <button type="button" onclick="toggleAllOrgs(true)">Select All</button>
                    <button type="button" onclick="toggleAllOrgs(false)">Deselect All</button>
                </div>
            </div>
            
            <div class="org-selection-grid">
                @foreach($organizations as $org)
                @php $isSelected = in_array($org->id, old('organization_ids', $selectedIds)); @endphp
                <label class="org-toggle-card {{ $isSelected ? 'selected' : '' }}" id="org-card-{{ $org->id }}">
                    <input type="checkbox" name="organization_ids[]" value="{{ $org->id }}" {{ $isSelected ? 'checked' : '' }} onchange="updateOrgCard(this, {{ $org->id }})">
                    <div class="org-toggle-info">{{ $org->name }}</div>
                </label>
                @endforeach
            </div>
            @error('organization_ids')
                <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Apply Preset Section -->
    <div class="config-section">
        <div class="config-section-header">
            <h3><i class='bx bx-category-alt'></i> Apply Preset Configuration</h3>
        </div>
        <div class="config-section-body">
            <div class="meta-fields">
                <div class="meta-field">
                    <label for="residential_type">Residential Type (Optional)</label>
                    <select id="residential_type" name="residential_type" onchange="applyPreset()" required>
                        <option value="">— Select Type to Auto-Configure —</option>
                        @foreach($residentialTypes as $key => $preset)
                            <option value="{{ $key }}" data-desc="{{ $preset['description'] }}">
                                {{ $preset['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="meta-field" style="display: flex; align-items: center; margin-top: 15px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; text-transform: none; letter-spacing: normal;">
                        <input type="checkbox" name="update_type" value="1" style="width: 18px; height: 18px; margin: 0;">
                        Update the "Residential Type" field on selected organizations to match this preset
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Configuration Section -->
    <div class="config-section">
        <div class="config-section-header">
            <h3><i class='bx bx-menu-alt-left'></i> Menus to Enable</h3>
            <span style="font-size: 13px; color: #94a3b8;">Selected menus will override current configs for the selected organizations.</span>
        </div>
        <div class="config-section-body">
            <div class="master-toggle-bar">
                <span id="selectedCount">0 of {{ count($menuItems) }} menus enabled</span>
                <div class="master-toggle-actions">
                    <button type="button" onclick="toggleAllMenus(true)">Enable All</button>
                    <button type="button" onclick="toggleAllMenus(false)">Disable All</button>
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
                    <label class="menu-toggle-card" id="card-{{ str_replace('.', '-', $key) }}" for="toggle-{{ str_replace('.', '-', $key) }}">
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
            <span id="saveBarText">Please select organizations to update.</span>
        </div>
        <button type="submit" class="btn-modern" id="submitBtn" style="opacity: 0.5; pointer-events: none;">
            <i class='bx bx-save'></i> Apply Configuration
        </button>
    </div>
</form>

@endsection

@push('scripts')
<script>
    const totalMenus = {{ count($menuItems) }};
    const presetRoute = "{{ url('/super-admin/menu-config/presets') }}";

    function updateOrgCard(checkbox, id) {
        const card = document.getElementById('org-card-' + id);
        if (checkbox.checked) {
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
        }
        updateOrgCount();
    }
    
    function toggleAllOrgs(select) {
        document.querySelectorAll('input[name="organization_ids[]"]').forEach(cb => {
            cb.checked = select;
            updateOrgCard(cb, cb.value);
        });
    }
    
    function updateOrgCount() {
        const count = document.querySelectorAll('input[name="organization_ids[]"]:checked').length;
        document.getElementById('orgSelectedCount').textContent = count + ' organizations selected';
        
        const btn = document.getElementById('submitBtn');
        const text = document.getElementById('saveBarText');
        
        if (count > 0) {
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
            text.innerHTML = 'Will apply selected menus to <strong>' + count + '</strong> organizations.';
        } else {
            btn.style.opacity = '0.5';
            btn.style.pointerEvents = 'none';
            text.innerHTML = 'Please select organizations to update.';
        }
    }

    function updateToggleCard(checkbox, key) {
        const card = document.getElementById('card-' + key);
        if (checkbox.checked) {
            card.classList.add('enabled');
        } else {
            card.classList.remove('enabled');
        }
        updateCount();
    }

    function updateCount() {
        const checked = document.querySelectorAll('input[name="enabled_menus[]"]:checked').length;
        document.getElementById('selectedCount').textContent = checked + ' of ' + totalMenus + ' menus enabled';
    }

    function toggleAllMenus(enable) {
        document.querySelectorAll('input[name="enabled_menus[]"]').forEach(cb => {
            cb.checked = enable;
            updateToggleCard(cb, cb.id.replace('toggle-', ''));
        });
    }

    function applyPreset() {
        const type = document.getElementById('residential_type').value;
        if (!type) return;

        fetch(presetRoute + '/' + type)
            .then(r => r.json())
            .then(data => {
                // First disable all
                toggleAllMenus(false);
                
                // Enable preset menus
                data.menus.forEach(key => {
                    const idSafeKey = key.replace(/\./g, '-');
                    const cb = document.getElementById('toggle-' + idSafeKey);
                    if (cb) {
                        cb.checked = true;
                        updateToggleCard(cb, idSafeKey);
                    }
                });
            })
            .catch(err => console.error('Failed to load preset:', err));
    }
    
    // Init state
    updateOrgCount();
    updateCount();
</script>
@endpush
