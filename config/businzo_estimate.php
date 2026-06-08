<?php

return [

    'range_markup' => 1.2,

    'base_prices' => [
        'web' => 25000,
        'mobile' => 160000,
        'ai' => 90000,
        'ecommerce' => 35000,
        'saas' => 150000,
        'custom' => 120000,
    ],

    'complexity_multipliers' => [
        'basic' => 7,
        'medium' => 14,
        'complex' => 21,
    ],

    'feature_prices' => [
        'auth' => 5000,
        'payment' => 15000,
        'chat' => 25000,
        'cms' => 20000,
        'multi_language' => 10000,
        'admin' => 15000,
        'multi_tenant' => 40000,
        'theme' => 25000,
    ],

    'type_labels' => [
        'web' => 'Web Application',
        'mobile' => 'Mobile Application',
        'ai' => 'AI / RAG Integration',
        'ecommerce' => 'eCommerce Solution',
        'saas' => 'Multi-Tenant SaaS',
        'custom' => 'Custom Software',
    ],

    'short_type_labels' => [
        'web' => 'Web App',
        'mobile' => 'Mobile App',
        'ai' => 'AI / RAG',
        'ecommerce' => 'eCommerce',
        'saas' => 'SaaS Platform',
        'custom' => 'Custom Dev',
    ],

    'complexity_labels' => [
        'basic' => 'Basic MVP',
        'medium' => 'Professional App',
        'complex' => 'Enterprise System',
    ],

    'timelines' => [
        'basic' => '2-4 Weeks',
        'medium' => '6-10 Weeks',
        'complex' => '3-6 Months',
    ],

    'features_by_type' => [
        'web' => [
            'required' => ['auth', 'admin'],
            'optional' => ['payment', 'chat', 'cms', 'multi_language', 'multi_tenant', 'theme'],
        ],
        'mobile' => [
            'required' => ['auth', 'chat'],
            'optional' => ['payment', 'cms', 'multi_language', 'admin', 'multi_tenant', 'theme'],
        ],
        'ai' => [
            'required' => ['auth', 'admin', 'cms'],
            'optional' => ['payment', 'chat', 'multi_language', 'multi_tenant', 'theme'],
        ],
        'ecommerce' => [
            'required' => ['auth', 'payment', 'admin'],
            'optional' => ['chat', 'cms', 'multi_language', 'multi_tenant', 'theme'],
        ],
        'saas' => [
            'required' => ['auth', 'admin', 'multi_tenant', 'theme'],
            'optional' => ['payment', 'chat', 'cms', 'multi_language'],
        ],
        'custom' => [
            'required' => ['auth', 'admin'],
            'optional' => ['payment', 'chat', 'cms', 'multi_language', 'multi_tenant', 'theme'],
        ],
    ],

];
