<?php

return [
    'variants' => [
        // Top navbar (desktop)
        'desktop' => [
            // Subtle ring so chips don’t vanish on the solid bar
            'base'     => 'nav-link-desktop ring-1 ring-white/10 shadow-[0_0_2px_color-mix(in_oklab,var(--color-electric-sky)_30%,transparent)]',
            'active'   => 'nav-link-active ring-2 ring-white/40 font-semibold',
            'inactive' => '',
        ],

        // Drawer links (mobile menu)
        'mobile' => [
            'base'     => 'nav-link-mobile ring-1 ring-white/10 shadow-[0_0_2px_color-mix(in_oklab,var(--color-electric-sky)_30%,transparent)]',
            'active'   => 'nav-link-active ring-white/25',
            'inactive' => '',
        ],

        // Desktop auth CTAs — map to real buttons for contrast
        'auth' => [
            'base'               => '',
            'active'             => 'btn btn-sm btn-primary',
            'inactive-login'     => 'btn btn-sm btn-secondary',
            'inactive-register'  => 'btn btn-sm btn-primary',
        ],

        // Mobile auth CTAs — same, full width in drawer
        'auth-mobile' => [
            'base'               => '',
            'active'             => 'btn btn-sm btn-primary btn-block',
            'inactive-login'     => 'btn btn-sm btn-secondary btn-block',
            'inactive-register'  => 'btn btn-sm btn-primary btn-block',
        ],
    ],
];
