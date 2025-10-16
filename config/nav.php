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
            'base'     => 'flex w-full items-center justify-between gap-3 rounded-2xl border border-white/12
                            bg-white/10 px-4 py-3 text-[16px] font-medium tracking-tight text-[color:var(--text-default)]
                            shadow-[0_14px_34px_rgba(15,17,35,.18)] transition-all duration-200',
            'active'   => 'bg-[color-mix(in_oklab,var(--color-electric-sky)_24%,transparent)]/90 border-white/24
                            shadow-[0_18px_42px_rgba(90,86,214,.28)] text-white',
            'inactive' => 'hover:bg-white/14 hover:border-white/18 hover:shadow-[0_20px_40px_rgba(15,17,35,.22)]
                            focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/40
                            focus-visible:ring-offset-2 focus-visible:ring-offset-transparent',
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
