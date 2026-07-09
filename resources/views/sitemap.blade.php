{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
@foreach ($pages as $page)
  <url>
    <loc>{{ $page['url'] }}</loc>
    <lastmod>{{ $page['lastmod'] }}</lastmod>
    <changefreq>{{ $page['changefreq'] }}</changefreq>
    <priority>{{ $page['priority'] }}</priority>
@foreach ($page['alternates'] as $locale => $url)
    <xhtml:link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}" />
@endforeach
    <xhtml:link rel="alternate" hreflang="x-default" href="{{ $page['alternates'][$defaultLocale] }}" />
  </url>
@endforeach
</urlset>
