@extends('admin.layouts.app')

@section('title', 'Simulasi & Perlindungan — Panel Admin CarAsset')
@section('page-title', 'Simulasi & Perlindungan')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website', 'route' => route('admin.pages.index')],
        ['label' => 'Simulasi & Perlindungan'],
    ]" />
@endsection

@push('styles')
    {{-- Shell/nav/panel/CTA/repeater generik dipakai ulang dari editor Home (PROMPT 17) --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-home-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-simulation-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-content-workflow.css') }}">
@endpush

@php
    $sectionLabels = [
        'assumptions' => 'Dasar Perhitungan',
        'one-unit' => 'Simulasi 1 Unit',
        'multiple-units' => 'Simulasi Beberapa Unit',
        'protection-monitoring' => 'Perlindungan & Monitoring',
        'disclaimer' => 'Disclaimer',
    ];

    $sectionFormViews = [
        'assumptions' => 'admin.pages.simulation.sections.assumptions-form',
        'one-unit' => 'admin.pages.simulation.sections.one-unit-form',
        'multiple-units' => 'admin.pages.simulation.sections.multiple-units-form',
        'protection-monitoring' => 'admin.pages.simulation.sections.protection-monitoring-form',
        'disclaimer' => 'admin.pages.simulation.sections.disclaimer-form',
    ];
@endphp

@section('content')
    <div class="ca-admin-home-editor-header">
        <p class="ca-admin-section__description">
            Kelola data simulasi, perbandingan unit, perlindungan, dan disclaimer tanpa membuat formula perhitungan baru.
        </p>
        <x-admin::button :href="route('simulation')" target="_blank" variant="outline" size="sm" icon="external-link">
            Lihat Halaman Simulasi
        </x-admin::button>
    </div>

    <div class="ca-admin-home-editor-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Nilai simulasi tidak dihitung otomatis. Masukkan hanya data yang telah dikonfirmasi. Gunakan status Menunggu Konfirmasi untuk nilai yang belum final.
    </div>

    <div class="ca-admin-home-editor-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Perubahan tersimpan langsung pada database. Namun nilai berstatus draft tidak ditampilkan sebagai data resmi pada halaman publik.
    </div>

    <div class="ca-admin-workflow-page-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Perubahan yang disimpan akan menjadi Draft. Website publik hanya berubah setelah Draft dipublikasikan.
    </div>

    <div class="ca-admin-home-editor">
        <nav class="ca-admin-home-nav" aria-label="Navigasi section Simulasi & Perlindungan">
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

                    <form method="POST" action="{{ route('admin.pages.simulation.sections.update', $key) }}" class="ca-admin-home-form" data-simulation-section-form>
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
    <script src="{{ asset('assets/admin/js/admin-simulation-editor.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-content-workflow.js') }}" defer></script>
@endpush
