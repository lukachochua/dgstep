<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="light" class="scroll-smooth">
<head>
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

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x" defer></script>

    <meta name="description" content="DGstep builds practical software platforms for growing businesses." />
    <meta name="robots" content="index, follow" />
    <meta property="og:title" content="{{ $title ?? 'DGstep' }}" />
    <meta property="og:description" content="Operational SaaS solutions for modern businesses." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <link rel="canonical" href="{{ url()->current() }}" />
</head>
<body>
  <div class="page-grid" aria-hidden="true"></div>

  <x-navbar />

  <main class="site-main min-h-[70vh]">
    {{ $slot }}
  </main>

  <x-footer />
</body>
</html>
