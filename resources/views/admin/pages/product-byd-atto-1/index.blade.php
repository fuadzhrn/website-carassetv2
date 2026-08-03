@extends('admin.layouts.app')

@section('title', 'Produk BYD ATTO 1 — Panel Admin CarAsset')
@section('page-title', 'Produk BYD ATTO 1')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website', 'route' => route('admin.pages.index')],
        ['label' => 'Produk BYD ATTO 1'],
    ]" />
@endsection

@php
    $adminPageAssetVersion = fn (string $relativePath) => file_exists(public_path($relativePath))
        ? '?v='.filemtime(public_path($relativePath))
        : '';
@endphp

@push('styles')
    {{-- Shell/nav/panel/CTA/repeater generik dipakai ulang dari editor Home (PROMPT 17) --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-home-editor.css').$adminPageAssetVersion('assets/admin/css/admin-home-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-product-byd-atto-1.css').$adminPageAssetVersion('assets/admin/css/admin-product-byd-atto-1.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-content-workflow.css').$adminPageAssetVersion('assets/admin/css/admin-content-workflow.css') }}">
@endpush

@php
    $sectionLabels = [
        'product-hero' => 'Hero Produk',
        'product-colors' => 'Galeri Kendaraan',
        'product-variants' => 'Varian',
        'product-specifications' => 'Spesifikasi & Fitur',
    ];

    $sectionFormViews = [
        'product-hero' => 'admin.pages.product-byd-atto-1.sections.product-hero-form',
        'product-colors' => 'admin.pages.product-byd-atto-1.sections.product-colors-form',
        'product-variants' => 'admin.pages.product-byd-atto-1.sections.product-variants-form',
        'product-specifications' => 'admin.pages.product-byd-atto-1.sections.product-specifications-form',
    ];
@endphp

@section('content')
    <div class="ca-admin-home-editor-header">
        <p class="ca-admin-section__description">
            Kelola tampilan, pilihan warna, varian, spesifikasi, fitur, dan keterkaitan BYD ATTO 1 dengan program CarAsset.
        </p>
        <x-admin::button :href="route('product.byd-atto-1')" target="_blank" variant="outline" size="sm" icon="external-link">
            Lihat Produk Published
        </x-admin::button>
    </div>

    <div class="ca-admin-home-editor-notice ca-admin-home-editor-notice--warning">
        <span data-lucide="alert-triangle" aria-hidden="true"></span>
        Gunakan hanya data produk dan aset yang telah dikonfirmasi. Jangan membuat varian, warna, spesifikasi, harga, atau klaim baru.
    </div>

    <div class="ca-admin-workflow-page-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Perubahan yang disimpan akan menjadi Draft. Website publik hanya berubah setelah Draft dipublikasikan.
    </div>

    <div class="ca-admin-home-editor">
        <nav class="ca-admin-home-nav" aria-label="Navigasi section Produk BYD ATTO 1">
            @foreach ($sectionLabels as $key => $label)
                <a href="#section-{{ $key }}" class="ca-admin-home-nav__link">
                    <span>{{ $label }}</span>
                    @if ($sections[$key]['is_active'])
                        <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
                    @else
                        <x-admin::status-badge variant="inactive">Nonaktif</x-admin::status-badge>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="ca-admin-home-panels">
            @foreach ($sectionLabels as $key => $label)
                @php
                    $sectionModel = $sectionModels->get($key);
                    $content = $sections[$key]['content'];
                    $isActive = $sections[$key]['is_active'];
                @endphp

                <section id="section-{{ $key }}" class="ca-admin-home-panel">
                    <div class="ca-admin-home-panel__header">
                        <div>
                            <h2 class="ca-admin-home-panel__title">{{ $label }}</h2>
                            @if ($sectionModel)
                                <x-admin::cms.workflow-status :section="$sectionModel" />
                            @endif
                        </div>

                        @if ($isActive)
                            <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
                        @else
                            <x-admin::status-badge variant="inactive">Nonaktif</x-admin::status-badge>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.pages.product-byd-atto-1.sections.update', $key) }}" class="ca-admin-home-form" data-product-section-form>
                        @csrf
                        @method('PATCH')

                        <x-admin::cms.section-status :checked="$isActive" />

                        @include($sectionFormViews[$key], ['content' => $content])

                        <div class="ca-admin-home-form__actions">
                            <x-admin::button type="submit" variant="primary">Simpan Draft</x-admin::button>
                        </div>
                    </form>

                    @if ($sectionModel)
                        <x-admin::cms.section-action-bar :page="$page" :section-key="$key" :has-draft="$sectionModel->hasDraft()" />
                    @endif
                </section>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/media-picker.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-repeaters.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-product-byd-atto-1.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-content-workflow.js') }}" defer></script>
@endpush
