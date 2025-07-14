<?php
return [
    'variants' => [
        'desktop' => [
            'base' => 'relative z-10 px-3 py-2 rounded-[3px] transition-colors duration-300 shadow-[0_0_4px_var(--color-electric-sky)] group',
            'active' => 'bg-[var(--color-electric-sky)] text-black border border-[var(--color-electric-sky)] group-hover:shadow-[0_0_8px_var(--color-electric-sky-hover)]',
            'inactive' => 'bg-transparent text-white border border-transparent hover:border-[var(--color-electric-sky)] hover:bg-white/5 hover:text-[var(--color-electric-sky)]',
        ],
        'mobile' => [
            'base' => 'block max-w-xs mx-auto px-4 py-2 rounded-md border shadow-[0_0_4px_var(--color-electric-sky)]',
            'active' => 'bg-[var(--color-electric-sky)] text-black border-[var(--color-electric-sky)] hover:shadow-[0_0_8px_var(--color-electric-sky-hover)]',
            'inactive' => 'bg-white/5 text-white border-transparent hover:bg-white/10',
        ],
        'auth' => [
            'base' => 'px-3 py-2 border rounded-[3px] transition-colors duration-300',
            'active' => 'bg-[var(--color-electric-sky)] text-black border-[var(--color-electric-sky)] shadow-[0_0_4px_var(--color-electric-sky)]',
            'inactive-login' => 'text-white border-white hover:bg-[var(--color-electric-sky)] hover:text-black hover:border-transparent',
            'inactive-register' => 'text-[var(--color-electric-sky)] border-[var(--color-electric-sky)] hover:bg-[var(--color-electric-sky)] hover:text-black hover:border-transparent',
        ],
        'auth-mobile' => [
            'base' => 'w-full max-w-xs px-4 py-2 border rounded-md transition focus-visible:outline-none',
            'active' => 'bg-[var(--color-electric-sky)] text-black border-[var(--color-electric-sky)]',
            'inactive-login' => 'text-white border-white hover:bg-[var(--color-electric-sky)] hover:text-black active:bg-[var(--color-electric-sky)] active:text-black',
            'inactive-register' => 'text-[var(--color-electric-sky)] border-[var(--color-electric-sky)] hover:bg-[var(--color-electric-sky)] hover:text-black active:bg-[var(--color-electric-sky)] active:text-black',
        ],
    ],
];
