<?php
return [
    'variants' => [
        // Top navbar (desktop)
        'desktop' => [
            // Keep your subtle electric glow via Tailwind's arbitrary shadow,
            // and attach our base desktop link styling.
            'base'     => 'nav-link-desktop group shadow-[0_0_4px_var(--color-electric-sky)]',
            // Active route = highlighted link (brand color)
            'active'   => 'nav-link-active',
            // Inactive uses the neutral state from nav-link-desktop; no extra classes needed.
            'inactive' => '',
        ],

        // Drawer links (mobile menu)
        'mobile' => [
            'base'     => 'nav-link-mobile shadow-[0_0_4px_var(--color-electric-sky)]',
            'active'   => 'nav-link-active',
            'inactive' => '',
        ],

        // Desktop auth CTAs (if/when used)
        'auth' => [
            // Base not needed (each state is a full CTA style)
            'base'               => '',
            // Active maps to the filled primary button
            'active'             => 'nav-link-auth-register',
            // Login = ghost/outline, Register = filled
            'inactive-login'     => 'nav-link-auth-login',
            'inactive-register'  => 'nav-link-auth-register',
        ],

        // Mobile auth CTAs (used in the drawer)
        'auth-mobile' => [
            'base'               => '',
            'active'             => 'nav-link-auth-register',
            'inactive-login'     => 'nav-link-auth-login',
            'inactive-register'  => 'nav-link-auth-register',
        ],
    ],
];
