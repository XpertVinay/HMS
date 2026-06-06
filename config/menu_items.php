<?php

/**
 * Admin Sidebar Menu Items Registry
 *
 * Single source of truth for all admin menu items.
 * Used by the sidebar partial and the Super Admin menu configuration UI.
 *
 * Keys are the unique menu identifiers stored in organization_menu_configs.enabled_menus.
 */

return [
    'announcements' => [
        'label'       => 'Notices',
        'icon'        => 'bx-bell',
        'route'       => 'admin.announcements.index',
        'match'       => 'announcements',
        'description' => 'Manage society notices & announcements',
        'group'       => 'Communication',
    ],
    'maintenance' => [
        'label'       => 'Maintenance',
        'icon'        => 'bx-pie-chart-alt-2',
        'route'       => 'admin.maintenance.index',
        'match'       => 'maintenance',
        'description' => 'Billing, invoicing & payment tracking',
        'group'       => 'Finance',
    ],
    'helpdesk' => [
        'label'       => 'Helpdesk',
        'icon'        => 'bx-support',
        'route'       => 'admin.helpdesk.index',
        'match'       => 'helpdesk',
        'description' => 'Resident complaint & ticket management',
        'group'       => 'Communication',
    ],
    'members' => [
        'label'       => 'Members',
        'icon'        => 'bx-list-ul',
        'route'       => 'admin.members.index',
        'match'       => 'members',
        'description' => 'Manage society members (owners)',
        'group'       => 'People',
    ],
    'staff' => [
        'label'       => 'Staff',
        'icon'        => 'bx-list-ul',
        'route'       => 'admin.staff.index',
        'match'       => 'admin.staff',
        'description' => 'Manage society staff accounts',
        'group'       => 'People',
    ],
    'residents' => [
        'label'       => 'Residents',
        'icon'        => 'bx-home-smile',
        'route'       => 'admin.residents.index',
        'match'       => 'residents',
        'description' => 'Manage residents & tenants',
        'group'       => 'People',
    ],
    'vendors' => [
        'label'       => 'Vendors',
        'icon'        => 'bx-store-alt',
        'route'       => 'admin.vendors.index',
        'match'       => 'vendors',
        'description' => 'Vendor marketplace & approvals',
        'group'       => 'Services',
    ],
    'properties' => [
        'label'       => 'Properties',
        'icon'        => 'bx-building-house',
        'route'       => 'admin.properties.index',
        'match'       => 'properties',
        'description' => 'Property & unit management',
        'group'       => 'Infrastructure',
    ],
    'donors' => [
        'label'       => 'Donors',
        'icon'        => 'bx-donate-heart',
        'route'       => 'admin.donors.index',
        'match'       => 'donors',
        'description' => 'Track donations & contributors',
        'group'       => 'Finance',
    ],
    'sponsors' => [
        'label'       => 'Sponsors',
        'icon'        => 'bx-star',
        'route'       => 'admin.sponsors.index',
        'match'       => 'sponsors',
        'description' => 'Manage event & society sponsors',
        'group'       => 'Finance',
    ],
    'events' => [
        'label'       => 'Events',
        'icon'        => 'bx-calendar-event',
        'route'       => 'admin.events.index',
        'match'       => 'events',
        'description' => 'Create & manage society events',
        'group'       => 'Community',
    ],
    'gallery' => [
        'label'       => 'Gallery',
        'icon'        => 'bx-image',
        'route'       => 'admin.gallery.index',
        'match'       => 'gallery',
        'description' => 'Photo gallery & media management',
        'group'       => 'Community',
    ],
    'solid_approvals' => [
        'label'       => 'SOLID Approvals',
        'icon'        => 'bx-check-square',
        'route'       => 'admin.solid.index',
        'match'       => 'solid.index',
        'description' => 'Sale, Occupancy, Lease, Interior & Decoration approvals',
        'group'       => 'Approvals',
    ],
    'solid_settings' => [
        'label'       => 'SOLID Settings',
        'icon'        => 'bx-cog',
        'route'       => 'admin.solid.settings',
        'match'       => 'solid.settings',
        'description' => 'Configure SOLID approval fees & policies',
        'group'       => 'Approvals',
    ],
    'community_approvals' => [
        'label'       => 'Comm. Approvals',
        'icon'        => 'bx-check-double',
        'route'       => 'admin.community.approvals',
        'match'       => 'community',
        'description' => 'Community network post approvals',
        'group'       => 'Community',
    ],
];
