@extends('layouts.app')

{{-- Title/meta description now come from PageSeoService (see partials.seo-meta) --}}
@section('body-class', 'ca-page ca-page--product-byd-atto-1')

@php
    // Cache-busting via filemtime(): the browser has no reason to treat
    // these page-specific stylesheets as long-lived (no Cache-Control is
    // sent for static assets under PHP's dev server), so a query string
    // that changes whenever the file itself changes forces a fresh fetch
    // instead of depending on the visitor manually clearing their cache.
    $productAssetVersion = fn (string $relativePath) => file_exists(public_path($relativePath))
        ? '?v='.filemtime(public_path($relativePath))
        : '';
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/product-byd-atto-1/product-byd-atto-1.css').$productAssetVersion('assets/css/pages/product-byd-atto-1/product-byd-atto-1.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/product-byd-atto-1/product-hero.css').$productAssetVersion('assets/css/pages/product-byd-atto-1/product-hero.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/product-byd-atto-1/product-colors.css').$productAssetVersion('assets/css/pages/product-byd-atto-1/product-colors.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/product-byd-atto-1/product-variants.css').$productAssetVersion('assets/css/pages/product-byd-atto-1/product-variants.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/product-byd-atto-1/product-specifications.css').$productAssetVersion('assets/css/pages/product-byd-atto-1/product-specifications.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive/product-byd-atto-1-mobile.css').$productAssetVersion('assets/css/responsive/product-byd-atto-1-mobile.css') }}">
@endpush

@section('content')
    @if ($product['product-hero']['is_active'])
        @include('pages.product-byd-atto-1.sections.product-hero', ['data' => $product['product-hero']])
    @endif

    @if ($product['product-colors']['is_active'])
        @include('pages.product-byd-atto-1.sections.product-colors', ['data' => $product['product-colors']])
    @endif

    @if ($product['product-variants']['is_active'])
        @include('pages.product-byd-atto-1.sections.product-variants', ['data' => $product['product-variants']])
    @endif

    @if ($product['product-specifications']['is_active'])
        @include('pages.product-byd-atto-1.sections.product-specifications', ['data' => $product['product-specifications']])
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/product-byd-atto-1.js').$productAssetVersion('assets/js/pages/product-byd-atto-1.js') }}" defer></script>
@endpush
