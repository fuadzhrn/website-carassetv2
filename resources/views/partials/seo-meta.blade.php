@php
    // $seo (title/description/robots/canonical) is set by the 5 public page
    // controllers + ContentPreviewController via PageSeoService — every
    // other view (auth pages, error pages, etc.) simply doesn't set it, and
    // this partial falls all the way back to the pre-PROMPT-24 @yield/
    // global-setting mechanism unchanged.
    $seoDefaultTitle = $siteSettings['seo.default_title'] ?? 'CarAsset — Mobil Bekerja. Aset Bertumbuh.';
    $seoDefaultDescription = $siteSettings['seo.default_description']
        ?? 'CarAsset membantu mengelola kendaraan produktif melalui sistem kemitraan yang profesional dan transparan.';

    $pageTitle = $seo['title'] ?? null;
    $pageDescription = $seo['description'] ?? null;
    $pageCanonical = $seo['canonical'] ?? null;

    // Preview always forces noindex regardless of the page's own (Draft or
    // Published) robots value — never the Draft's target robots.
    $pageRobots = ($previewMode ?? false)
        ? 'noindex, nofollow, noarchive'
        : str_replace(',', ', ', $seo['robots'] ?? ($siteSettings['seo.default_robots'] ?? 'index,follow'));

    $faviconSrc = $siteFaviconUrl ?? (file_exists(public_path('assets/images/brand/favicon.png'))
        ? asset('assets/images/brand/favicon.png')
        : asset('favicon.ico'));
@endphp

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $pageTitle ?? $seoDefaultTitle }}</title>
@if ($pageDescription ?? $seoDefaultDescription)
    <meta name="description" content="{{ $pageDescription ?? $seoDefaultDescription }}">
@endif
<meta name="robots" content="{{ $pageRobots }}">
<meta name="theme-color" content="#0F172A">

<link rel="canonical" href="{{ $pageCanonical ?? url()->current() }}">

<link rel="icon" href="{{ $faviconSrc }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@500;600;700&family=Poppins:wght@400;500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
