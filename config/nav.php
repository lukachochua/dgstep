<?php

return [
    'variants' => [
        // Top navbar (desktop)
        'desktop' => [
            // Chip-like anchors on a translucent bar
            'base'     => 'nav-link-desktop',
            'active'   => 'nav-link-active',
            'inactive' => '',
        ],

        // Drawer links (mobile menu)
        'mobile' => [
            'base'     => 'nav-link-mobile ring-1 ring-white/10 shadow-[0_0_2px_color-mix(in_oklab,var(--color-electric-sky)_28%,transparent)]',
            'active'   => 'nav-link-active ring-white/25',
            'inactive' => '',
        ],

        // Desktop auth CTAs — mapped to real buttons for contrast
        'auth' => [
            'base'               => '',
            'active'             => 'btn btn-sm btn-primary',
            'inactive-login'     => 'btn btn-sm btn-secondary',
            'inactive-register'  => 'btn btn-sm btn-primary',
        ],

        // Mobile auth CTAs — full width in drawer
        'auth-mobile' => [
            'base'               => '',
            'active'             => 'btn btn-sm btn-primary btn-block',
            'inactive-login'     => 'btn btn-sm btn-secondary btn-block',
            'inactive-register'  => 'btn btn-sm btn-primary btn-block',
        ],
    ],
];
