<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light" class="scroll-smooth">
<head>
    @php
      $locale = app()->getLocale();
      $siteName = 'DGstep';
      $fallbackDescription = $locale === 'ka'
        ? 'DGstep ქმნის პრაქტიკულ პროგრამულ პლატფორმებს მზარდი ბიზნესებისთვის.'
        : 'DGstep builds practical software platforms for growing businesses.';
      $pageTitle = trim((string) (filled($seo['title'] ?? null) ? $seo['title'] : ($title ?? $siteName)));
      $pageTitle = $pageTitle !== '' ? $pageTitle : $siteName;
      $metaDescription = trim((string) (filled($seo['description'] ?? null) ? $seo['description'] : $fallbackDescription));
      $ogTitle = trim((string) (filled($seo['og_title'] ?? null) ? $seo['og_title'] : $pageTitle));
      $ogDescription = trim((string) (filled($seo['og_description'] ?? null) ? $seo['og_description'] : $metaDescription));
      $canonical = $seo['canonical'] ?? url()->current();
      $robots = $seo['robots'] ?? 'index, follow';
      $ogLocale = $locale === 'ka' ? 'ka_GE' : 'en_US';
      $ogLocaleAlternate = $locale === 'ka' ? 'en_US' : 'ka_GE';
      $defaultOgImage = asset(Vite::asset('resources/images/brand/logo-color-01.png'));
      $ogImage = $seo['image'] ?? $defaultOgImage;
      $firaGoMedium = asset(Vite::asset('resources/fonts/firago/FiraGO-Medium.woff2'));
      $firaGoBold = asset(Vite::asset('resources/fonts/firago/FiraGO-Bold.woff2'));
      $alternateUrl = fn (string $targetLocale) => request()->fullUrlWithQuery(['locale' => $targetLocale]);
      $defaultLocale = in_array(config('app.locale'), ['ka', 'en'], true) ? config('app.locale') : 'ka';
      $organizationId = url('/#organization');
      $websiteId = url('/#website');
      $globalStructuredData = [
        [
          '@context' => 'https://schema.org',
          '@type' => 'Organization',
          '@id' => $organizationId,
          'name' => $siteName,
          'url' => url('/'),
          'logo' => $defaultOgImage,
          'foundingLocation' => [
            '@type' => 'Place',
            'address' => [
              '@type' => 'PostalAddress',
              'addressCountry' => 'GE',
            ],
          ],
          'areaServed' => [
            '@type' => 'Country',
            'name' => 'Georgia',
          ],
          'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => __('contact.cta_phone_href'),
            'contactType' => 'customer support',
            'availableLanguage' => ['ka', 'en'],
          ],
        ],
        [
          '@context' => 'https://schema.org',
          '@type' => 'WebSite',
          '@id' => $websiteId,
          'name' => $siteName,
          'url' => url('/'),
          'publisher' => ['@id' => $organizationId],
          'inLanguage' => $locale,
        ],
      ];
      $jsonLd = array_values(array_filter([...$globalStructuredData, ...$structuredData]));
    @endphp
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $pageTitle }}</title>

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
    <link rel="preload" href="{{ $firaGoBold }}" as="font" type="font/woff2" crossorigin>
    <noscript>
      <style>
        .site-nav .nav-links,
        .site-nav .nav-actions {
          visibility: visible !important;
        }

        .ltr-reveal,
        .reveal,
        .stagger > * {
          opacity: 1 !important;
          transform: none !important;
          filter: none !important;
          animation: none !important;
        }
      </style>
    </noscript>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="description" content="{{ $metaDescription }}" />
    <meta name="robots" content="{{ $robots }}" />
    <meta property="og:site_name" content="{{ $siteName }}" />
    <meta property="og:title" content="{{ $ogTitle }}" />
    <meta property="og:description" content="{{ $ogDescription }}" />
    <meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}" />
    <meta property="og:url" content="{{ $canonical }}" />
    <meta property="og:locale" content="{{ $ogLocale }}" />
    <meta property="og:locale:alternate" content="{{ $ogLocaleAlternate }}" />
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $ogTitle }}" />
    <meta name="twitter:description" content="{{ $ogDescription }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />
    <link rel="canonical" href="{{ $canonical }}" />
    <link rel="alternate" hreflang="ka" href="{{ $alternateUrl('ka') }}" />
    <link rel="alternate" hreflang="en" href="{{ $alternateUrl('en') }}" />
    <link rel="alternate" hreflang="x-default" href="{{ $alternateUrl($defaultLocale) }}" />

    @foreach ($jsonLd as $schema)
      <script type="application/ld+json">@json($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</script>
    @endforeach
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
