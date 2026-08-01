@extends('admin.layouts.app')

@section('title', 'Bisnis CarAsset — Panel Admin CarAsset')
@section('page-title', 'Bisnis CarAsset')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website', 'route' => route('admin.pages.index')],
        ['label' => 'Bisnis CarAsset'],
    ]" />
@endsection

@push('styles')
    {{-- Shell/nav/panel/CTA/repeater generik dipakai ulang dari editor Home (PROMPT 17) --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-home-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-business-editor.css') }}">
@endpush

@php
    $sectionLabels = [
        'opportunity' => 'Peluang Bisnis Kendaraan Produktif',
        'own' => 'OWN',
        'operate' => 'OPERATE',
        'grow' => 'GROW',
        'business-flow' => 'Alur Bisnis',
    ];

    $sectionFormViews = [
        'opportunity' => 'admin.pages.business.sections.opportunity-form',
        'own' => 'admin.pages.business.sections.own-form',
        'operate' => 'admin.pages.business.sections.operate-form',
        'grow' => 'admin.pages.business.sections.grow-form',
        'business-flow' => 'admin.pages.business.sections.business-flow-form',
    ];
@endphp

@section('content')
    <div class="ca-admin-home-editor-header">
        <p class="ca-admin-section__description">
            Kelola konten lima section halaman Bisnis CarAsset tanpa mengubah struktur desain publik.
        </p>
        <x-admin::button :href="route('business')" target="_blank" variant="outline" size="sm" icon="external-link">
            Lihat Halaman Bisnis
        </x-admin::button>
    </div>

    <div class="ca-admin-home-editor-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Perubahan yang disimpan akan langsung tampil pada halaman publik karena fitur Draft dan Publish belum dibangun.
    </div>

    <div class="ca-admin-home-editor">
        <nav class="ca-admin-home-nav" aria-label="Navigasi section Bisnis CarAsset">
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
                            @if ($sectionModel?->updated_at)
                                <p class="ca-admin-home-panel__meta">
                                    Terakhir diperbarui {{ $sectionModel->updated_at->translatedFormat('d F Y, H:i') }}
                                    @if ($sectionModel->updatedBy)
                                        oleh {{ $sectionModel->updatedBy->name }}
                                    @endif
                                </p>
                            @endif
                        </div>

                        @if ($isActive)
                            <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
                        @else
                            <x-admin::status-badge variant="inactive">Nonaktif</x-admin::status-badge>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('admin.pages.business.sections.update', $key) }}" class="ca-admin-home-form" data-business-section-form>
                        @csrf
                        @method('PATCH')

                        <x-admin::cms.section-status :checked="$isActive" />

                        @include($sectionFormViews[$key], ['content' => $content])

                        <div class="ca-admin-home-form__actions">
                            <x-admin::button type="submit" variant="primary">Simpan Section</x-admin::button>
                        </div>
                    </form>
                </section>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/media-picker.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-business-editor.js') }}" defer></script>
@endpush
