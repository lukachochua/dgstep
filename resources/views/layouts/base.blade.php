<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth" data-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'DGstep' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

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

    <!-- SEO Meta -->
    <meta name="description" content="DGstep builds modern platforms for Georgian SMBs and pawnshops." />
    <meta name="keywords" content="DGstep, software Georgia, Laravel, Alpine.js, Tailwind, pawnshop app" />
    <meta name="author" content="DGstep">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="{{ $title ?? 'DGstep – Software for Georgian Businesses' }}">
    <meta property="og:description" content="Custom Laravel + Alpine.js platforms for SMBs in Georgia.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-preview.jpg') }}">
    <meta property="og:locale" content="en_US">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'DGstep – Software for Georgian Businesses' }}">
    <meta name="twitter:description" content="Tailored software solutions for Georgian SMBs.">
    <meta name="twitter:image" content="{{ asset('images/og-preview.jpg') }}">

    <link rel="canonical" href="{{ url()->current() }}">
</head>

<body
    class="font-sans text-[17px] leading-relaxed antialiased dark:bg-[var(--bg-default)] dark:text-[var(--text-default)] transition-colors duration-300 ease-in-out">
    <div class="page-wrapper min-h-screen flex flex-col">
        <main class="flex-grow">
            <x-navbar />
            {{ $slot }}
        </main>
        <x-footer />
    </div>
</body>

</html>
