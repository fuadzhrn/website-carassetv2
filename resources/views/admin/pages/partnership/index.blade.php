@extends('admin.layouts.app')

@section('title', 'Program Kemitraan — Panel Admin CarAsset')
@section('page-title', 'Program Kemitraan')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website', 'route' => route('admin.pages.index')],
        ['label' => 'Program Kemitraan'],
    ]" />
@endsection

@push('styles')
    {{-- Shell/nav/panel/CTA/repeater generik dipakai ulang dari editor Home (PROMPT 17) --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-home-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-partnership-editor.css') }}">
@endpush

@php
    $sectionLabels = [
        'program-selector' => 'Pilih Program Anda',
        'owner-program' => 'Mitra Owner',
        'driver-program' => 'Mitra Driver',
        'packages-benefits' => 'Paket & Benefit',
        'terms' => 'Persyaratan & Ketentuan',
    ];

    $sectionFormViews = [
        'program-selector' => 'admin.pages.partnership.sections.program-selector-form',
        'owner-program' => 'admin.pages.partnership.sections.owner-program-form',
        'driver-program' => 'admin.pages.partnership.sections.driver-program-form',
        'packages-benefits' => 'admin.pages.partnership.sections.packages-benefits-form',
        'terms' => 'admin.pages.partnership.sections.terms-form',
    ];
@endphp

@section('content')
    <div class="ca-admin-home-editor-header">
        <p class="ca-admin-section__description">
            Kelola konten lima section halaman Program Kemitraan tanpa mengubah struktur desain publik.
        </p>
        <x-admin::button :href="route('partnership')" target="_blank" variant="outline" size="sm" icon="external-link">
            Lihat Halaman Program Kemitraan
        </x-admin::button>
    </div>

    <div class="ca-admin-home-editor-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Perubahan yang disimpan akan langsung tampil pada halaman publik karena fitur Draft dan Publish belum dibangun.
    </div>

    <div class="ca-admin-home-editor">
        <nav class="ca-admin-home-nav" aria-label="Navigasi section Program Kemitraan">
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

                    @if ($key === 'terms')
                        <p class="ca-admin-legal-notice">
                            <span data-lucide="alert-triangle" aria-hidden="true"></span>
                            Konten pada bagian ini bersifat informasional. Pastikan setiap perubahan telah sesuai
                            dengan dokumen resmi dan persetujuan pihak yang berwenang.
                        </p>
                    @endif

                    <form method="POST" action="{{ route('admin.pages.partnership.sections.update', $key) }}" class="ca-admin-home-form" data-partnership-section-form>
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
    <script src="{{ asset('assets/admin/js/admin-repeaters.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-partnership-editor.js') }}" defer></script>
@endpush
