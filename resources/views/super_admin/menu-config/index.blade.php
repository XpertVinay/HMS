@extends('layouts.portal')
@section('title', 'Menu Configuration')

@push('styles')
<style>
    .config-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .config-header h2 {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
    }
    .config-header .subtitle {
        font-size: 14px;
        color: #64748b;
        margin-top: 4px;
    }

    /* Search & Filter Bar */
    .filter-bar {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }
    .filter-bar input,
    .filter-bar select {
        padding: 10px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        background: #fff;
        color: #334155;
        transition: all 0.2s;
        min-width: 200px;
    }
    .filter-bar input:focus,
    .filter-bar select:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
    }

    /* Organization Cards Grid */
    .org-config-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 20px;
    }
    .org-config-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }
    .org-config-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px -5px rgba(0,0,0,0.1);
        border-color: #e2e8f0;
    }
    .org-card-header {
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid #f1f5f9;
    }
    .org-avatar {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #8b5cf6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 18px;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(79,70,229,0.25);
    }
    .org-info h3 {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .org-info .org-subdomain {
        font-size: 13px;
        color: #94a3b8;
        font-family: 'Menlo', monospace;
    }

    .org-card-body {
        padding: 20px 24px;
    }
    .org-meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .org-meta-row:last-child {
        border-bottom: none;
    }
    .meta-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 600;
    }
    .meta-value {
        font-size: 13px;
        color: #334155;
        font-weight: 600;
    }
    .type-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .type-badge.apartment { background: #ede9fe; color: #6d28d9; }
    .type-badge.villa { background: #fef3c7; color: #d97706; }
    .type-badge.independent_house { background: #dcfce7; color: #16a34a; }
    .type-badge.township { background: #dbeafe; color: #2563eb; }
    .type-badge.commercial { background: #fce7f3; color: #db2777; }
    .type-badge.none { background: #f1f5f9; color: #94a3b8; }

    /* Menu count progress */
    .menu-progress {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .menu-progress-bar {
        flex: 1;
        height: 6px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }
    .menu-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-color), #8b5cf6);
        border-radius: 10px;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .menu-count {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        white-space: nowrap;
    }

    .org-card-footer {
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 8px;
    }
    .org-card-footer .btn-modern {
        flex: 1;
        text-align: center;
        font-size: 13px;
        padding: 8px 16px;
    }

    /* Bulk action bar */
    .bulk-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
        border-radius: 14px;
        margin-bottom: 24px;
        color: #fff;
    }
    .bulk-bar i {
        font-size: 22px;
        color: #a5b4fc;
    }
    .bulk-bar span {
        font-size: 14px;
        font-weight: 500;
        flex: 1;
    }

    /* Checkbox card selection */
    .org-config-card .card-select {
        position: absolute;
        top: 16px;
        right: 16px;
        z-index: 2;
    }
    .org-config-card {
        position: relative;
    }
    .card-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid #cbd5e1;
        cursor: pointer;
        transition: all 0.2s;
        appearance: none;
        -webkit-appearance: none;
        background: #fff;
    }
    .card-checkbox:checked {
        background: var(--primary-color);
        border-color: var(--primary-color);
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3E%3C/svg%3E");
        background-size: 14px;
        background-repeat: no-repeat;
        background-position: center;
    }

    .empty-state {
        text-align: center;
        padding: 60px 40px;
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 56px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    .empty-state h3 {
        font-size: 18px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .org-config-grid {
            grid-template-columns: 1fr;
        }
        .config-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .filter-bar {
            flex-direction: column;
        }
        .filter-bar input,
        .filter-bar select {
            min-width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="config-header">
    <div>
        <h2><i class='bx bx-menu-alt-left' style="color: var(--primary-color);"></i> Menu Configuration</h2>
        <div class="subtitle">Configure which menu items are visible to each RWA Admin</div>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('super_admin.menu_config.bulk_edit') }}" class="btn-modern btn-outline" id="btn-bulk-edit">
            <i class='bx bx-layer'></i> Bulk Edit
        </a>
    </div>
</div>

<!-- Filter Bar -->
<form method="GET" action="{{ route('super_admin.menu_config.index') }}" class="filter-bar">
    <input type="text" name="search" placeholder="🔍 Search by name, subdomain or location..." value="{{ request('search') }}">
    <select name="type" onchange="this.form.submit()">
        <option value="">All Residential Types</option>
        @foreach($residentialTypes as $key => $preset)
            <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $preset['label'] }}</option>
        @endforeach
    </select>
    @if(request('search') || request('type'))
        <a href="{{ route('super_admin.menu_config.index') }}" class="btn-modern btn-sm btn-outline">Clear</a>
    @endif
</form>

<!-- Stats Info -->
<div class="bulk-bar">
    <i class='bx bx-buildings'></i>
    <span>{{ $organizations->count() }} organization(s) found &mdash; {{ $organizations->filter(fn($o) => $o->menuConfig)->count() }} configured</span>
</div>

@if($organizations->isEmpty())
    <div class="empty-state">
        <i class='bx bx-folder-open'></i>
        <h3>No organizations found</h3>
        <p>Try adjusting your search or filter criteria.</p>
    </div>
@else
    <!-- Organization Cards -->
    <div class="org-config-grid">
        @foreach($organizations as $org)
        @php
            $enabled = $org->menuConfig ? count($org->menuConfig->enabled_menus) : count($menuItems);
            $total = count($menuItems);
            $percent = $total > 0 ? round(($enabled / $total) * 100) : 100;
            $type = $org->residential_type;
        @endphp
        <div class="org-config-card" data-org-id="{{ $org->id }}">
            <div class="org-card-header">
                <div class="org-avatar">{{ strtoupper(substr($org->name, 0, 2)) }}</div>
                <div class="org-info">
                    <h3>{{ $org->name }}</h3>
                    <div class="org-subdomain">{{ $org->subdomain }}.businzo.com</div>
                </div>
            </div>

            <div class="org-card-body">
                <div class="org-meta-row">
                    <span class="meta-label">Status</span>
                    <span class="badge-status {{ $org->status }}">{{ ucfirst($org->status) }}</span>
                </div>
                <div class="org-meta-row">
                    <span class="meta-label">Residential Type</span>
                    <span class="type-badge {{ $type ?? 'none' }}">{{ $type ? str_replace('_', ' ', $type) : 'Not Set' }}</span>
                </div>
                <div class="org-meta-row">
                    <span class="meta-label">Location</span>
                    <span class="meta-value">{{ $org->location ?? '—' }}</span>
                </div>
                <div class="org-meta-row">
                    <span class="meta-label">Admins / Members</span>
                    <span class="meta-value">{{ $org->admins_count }} / {{ $org->members_count }}</span>
                </div>
                <div class="org-meta-row">
                    <span class="meta-label">Enabled Menus</span>
                    <div class="menu-progress">
                        <div class="menu-progress-bar">
                            <div class="menu-progress-fill" style="width: {{ $percent }}%"></div>
                        </div>
                        <span class="menu-count">{{ $enabled }}/{{ $total }}</span>
                    </div>
                </div>
            </div>

            <div class="org-card-footer">
                <a href="{{ route('super_admin.menu_config.edit', $org->id) }}" class="btn-modern btn-sm">
                    <i class='bx bx-edit-alt'></i> Configure
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection
