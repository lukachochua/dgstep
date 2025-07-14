<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'DGstep' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.web-fonts.ge/fonts/bpg-nino-mtavruli/css/bpg-nino-mtavruli.min.css">

    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        :root {
            --color-electric-sky: #00a7ff;
            --color-electric-sky-hover: #008fdb;
            --color-electric-sky-focus: #005f9e;
        }

        [data-theme='dark'] {
            --color-electric-sky: #66ccff;
            --color-electric-sky-hover: #3399ff;
            --color-electric-sky-focus: #1a73e8;
            --bg-default: #121212;
            --text-default: #e0e0e0;
            --bg-elevated: #1e1e1e;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        .page-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>

    <!-- Basic SEO -->
    <meta name="description"
        content="DGstep is a Tbilisi-based software studio building modern platforms for pawnshops and small businesses across Georgia. Simplify your operations with custom Laravel solutions." />
    <meta name="keywords"
        content="DGstep, software development Georgia, pawnshop software, Laravel studio, Tbilisi tech company, business tools Georgia, ERP Georgia, Alpine.js, Tailwind CSS, Laravel 12" />
    <meta name="author" content="DGstep">
    <meta name="robots" content="index, follow">

    <!-- Open Graph for social media -->
    <meta property="og:title" content="{{ $title ?? 'DGstep – Modern Software for Georgian Businesses' }}">
    <meta property="og:description"
        content="DGstep helps businesses in Tbilisi and across Georgia digitize operations with tailored Laravel and Alpine.js solutions.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-preview.jpg') }}"> {{-- Optional: replace with actual image --}}
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'DGstep – Modern Software for Georgian Businesses' }}">
    <meta name="twitter:description"
        content="Custom-built tools for pawnshops and small businesses in Georgia. Fast. Compliant. Reliable.">
    <meta name="twitter:image" content="{{ asset('images/og-preview.jpg') }}">

    <!-- Canonical -->
    <link rel="canonical" href="{{ url()->current() }}">

</head>

<body
    class="font-sans antialiased dark:bg-[var(--bg-default)] dark:text-[var(--text-default)] transition-colors duration-300 ease-in-out">

    <div
        class="page-wrapper bg-gradient-to-r from-[#0b0f1a] via-[#6d6be4] to-[#a369ff] dark:bg-[var(--bg-default)] text-gray-900 dark:text-[var(--text-default)] selection:bg-[var(--color-electric-sky)] selection:text-white">
        <main>
            <x-navbar />
            {{ $slot }}

            <x-footer />
        </main>
    </div>

    <script>
        (() => {
            const themeToggleKey = 'dgstep-theme';
            const htmlEl = document.documentElement;
            const currentTheme = localStorage.getItem(themeToggleKey);

            if (currentTheme === 'dark') {
                htmlEl.setAttribute('data-theme', 'dark');
            }

            window.toggleTheme = () => {
                const isDark = htmlEl.getAttribute('data-theme') === 'dark';
                htmlEl.setAttribute('data-theme', isDark ? 'light' : 'dark');
                localStorage.setItem(themeToggleKey, isDark ? 'light' : 'dark');
            };

            function setDynamicHeight() {
                const wrapper = document.querySelector('.page-wrapper');
                if (wrapper) {
                    wrapper.style.height = window.innerHeight + 'px';
                }
            }

            setDynamicHeight();
            window.addEventListener('resize', setDynamicHeight);
            window.addEventListener('orientationchange', () => setTimeout(setDynamicHeight, 100));
        })();
    </script>
</body>

</html>
