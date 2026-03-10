<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light" class="scroll-smooth">
<head>
    @php
      $locale = app()->getLocale();
      $metaDescription = $locale === 'ka'
        ? 'DGstep ქმნის პრაქტიკულ პროგრამულ პლატფორმებს მზარდი ბიზნესებისთვის.'
        : 'DGstep builds practical software platforms for growing businesses.';
      $ogDescription = $locale === 'ka'
        ? 'ოპერაციული SaaS გადაწყვეტები თანამედროვე ბიზნესებისთვის.'
        : 'Operational SaaS solutions for modern businesses.';
      $ogLocale = $locale === 'ka' ? 'ka_GE' : 'en_US';
      $ogLocaleAlternate = $locale === 'ka' ? 'en_US' : 'ka_GE';
      $ogImage = asset(Vite::asset('resources/images/brand/logo-color-01.png'));
      $firaGoMedium = asset(Vite::asset('resources/fonts/firago/FiraGO-Medium.woff2'));
    @endphp
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'DGstep' }}</title>

    <script>
      (function () {
        try {
          var key = 'dg:theme';
          var saved = localStorage.getItem(key);
          var theme = (saved === 'light' || saved === 'dark')
            ? saved
            : (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
          document.documentElement.setAttribute('data-theme', theme);
        } catch (_) {}
      })();
    </script>

    <link rel="preload" href="{{ $firaGoMedium }}" as="font" type="font/woff2" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="description" content="{{ $metaDescription }}" />
    <meta name="robots" content="index, follow" />
    <meta property="og:title" content="{{ $title ?? 'DGstep' }}" />
    <meta property="og:description" content="{{ $ogDescription }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:locale" content="{{ $ogLocale }}" />
    <meta property="og:locale:alternate" content="{{ $ogLocaleAlternate }}" />
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $title ?? 'DGstep' }}" />
    <meta name="twitter:description" content="{{ $ogDescription }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />
    <link rel="canonical" href="{{ url()->current() }}" />
</head>
<body>
  <div class="page-grid" aria-hidden="true"></div>
  <a href="#main-content" class="skip-link">Skip to main content</a>

  <x-navbar />

  <main id="main-content" class="site-main min-h-[70vh]">
    {{ $slot }}
  </main>

  <x-footer />
</body>
</html>
