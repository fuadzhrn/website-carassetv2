@php
    $seoDefaultTitle = $siteSettings['seo.default_title'] ?? 'CarAsset — Mobil Bekerja. Aset Bertumbuh.';
    $seoDefaultDescription = $siteSettings['seo.default_description']
        ?? 'CarAsset membantu mengelola kendaraan produktif melalui sistem kemitraan yang profesional dan transparan.';
    $seoDefaultRobots = str_replace(',', ', ', $siteSettings['seo.default_robots'] ?? 'index,follow');

    $faviconSrc = $siteFaviconUrl ?? (file_exists(public_path('assets/images/brand/favicon.png'))
        ? asset('assets/images/brand/favicon.png')
        : asset('favicon.ico'));
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', $seoDefaultTitle)</title>
<meta name="description" content="@yield('meta_description', $seoDefaultDescription)">
<meta name="robots" content="@yield('robots', $seoDefaultRobots)">
<meta name="theme-color" content="#0F172A">

<link rel="canonical" href="{{ url()->current() }}">

<link rel="icon" href="{{ $faviconSrc }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@500;600;700&family=Poppins:wght@400;500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
