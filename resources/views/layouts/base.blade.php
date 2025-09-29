<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'DGstep' }}</title>

    {{-- Pre-init theme to avoid flash (single source of truth: dg:theme) --}}
    <script>
      (function () {
        try {
          var KEY = 'dg:theme';
          var saved = localStorage.getItem(KEY);
          var theme = (saved === 'light' || saved === 'dark')
            ? saved
            : (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
          document.documentElement.setAttribute('data-theme', theme);
        } catch (_) {}
      })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js for navbar + hero interactivity --}}
    <script src="https://unpkg.com/alpinejs@3.x.x" defer></script>

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
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) ?: 'en-US' }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? 'DGstep – Software for Georgian Businesses' }}">
    <meta name="twitter:description" content="Tailored software solutions for Georgian SMBs.">
    <meta name="twitter:image" content="{{ asset('images/og-preview.jpg') }}">

    <link rel="preload" as="image" href="{{ Vite::asset('resources/images/brand/logo-white-01.png') }}">

    <link rel="canonical" href="{{ url()->current() }}">
</head>

<body
  class="font-sans text-[17px] leading-relaxed antialiased
         bg-[var(--bg-default)] text-[var(--text-default)]
         transition-colors duration-300 ease-in-out"
>
  <div class="page-wrapper min-h-screen flex flex-col">
    <main class="flex-grow">
      <x-navbar />
      {{ $slot }}
    </main>
    <x-footer />
  </div>
</body>
</html>
