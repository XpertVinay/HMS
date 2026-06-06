<?php

/**
 * Menu Presets by Residential Area Type
 *
 * When a Super Admin selects a residential type for an organization,
 * these presets auto-populate the suggested enabled menus.
 * The Super Admin can still override individual toggles after applying a preset.
 *
 * Keys must match the residential_type values in the organizations table.
 * Values are arrays of menu_item keys from config/menu_items.php.
 */

return [
    'apartment' => [
        'label' => 'Apartment / Flat Complex',
        'description' => 'High-rise or multi-story apartment buildings with shared amenities',
        'menus' => [
            'announcements',
            'maintenance',
            'helpdesk',
            'members',
            'staff',
            'residents',
            'vendors',
            'properties',
            'donors',
            'sponsors',
            'events',
            'gallery',
            'solid_approvals',
            'solid_settings',
            'community_approvals',
        ],
    ],

    'villa' => [
        'label' => 'Villa / Gated Community',
        'description' => 'Independent villas within a gated community with shared infrastructure',
        'menus' => [
            'announcements',
            'maintenance',
            'helpdesk',
            'members',
            'staff',
            'residents',
            'vendors',
            'properties',
            'events',
            'gallery',
            'community_approvals',
        ],
    ],

    'independent_house' => [
        'label' => 'Independent House Colony',
        'description' => 'Colony of independent houses with basic shared governance',
        'menus' => [
            'announcements',
            'maintenance',
            'helpdesk',
            'members',
            'staff',
            'properties',
            'events',
            'gallery',
        ],
    ],

    'township' => [
        'label' => 'Township / Integrated Campus',
        'description' => 'Large township with mixed residential, commercial & recreational zones',
        'menus' => [
            'announcements',
            'maintenance',
            'helpdesk',
            'members',
            'staff',
            'residents',
            'vendors',
            'properties',
            'donors',
            'sponsors',
            'events',
            'gallery',
            'solid_approvals',
            'solid_settings',
            'community_approvals',
        ],
    ],

    'commercial' => [
        'label' => 'Commercial Complex',
        'description' => 'Office buildings, shops & commercial spaces',
        'menus' => [
            'announcements',
            'maintenance',
            'helpdesk',
            'members',
            'staff',
            'vendors',
            'properties',
            'events',
        ],
    ],
];
