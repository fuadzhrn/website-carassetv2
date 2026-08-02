@extends('admin.layouts.app')

@section('title', 'Tentang & Kontak — Panel Admin CarAsset')
@section('page-title', 'Tentang & Kontak')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website', 'route' => route('admin.pages.index')],
        ['label' => 'Tentang & Kontak'],
    ]" />
@endsection

@push('styles')
    {{-- Shell/nav/panel/CTA/repeater generik dipakai ulang dari editor Home (PROMPT 17) --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-home-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-about-contact-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-content-workflow.css') }}">
@endpush

@php
    $sectionLabels = [
        'about' => 'About',
        'vision-mission-values' => 'Vision, Mission & Values',
        'legal-partners' => 'Legal & Partners',
        'faq' => 'FAQ',
        'contact-form' => 'Contact Form Content',
    ];

    $sectionFormViews = [
        'about' => 'admin.pages.about-contact.sections.about-form',
        'vision-mission-values' => 'admin.pages.about-contact.sections.vision-mission-values-form',
        'legal-partners' => 'admin.pages.about-contact.sections.legal-partners-form',
        'faq' => 'admin.pages.about-contact.sections.faq-form',
        'contact-form' => 'admin.pages.about-contact.sections.contact-form-content-form',
    ];
@endphp

@section('content')
    <div class="ca-admin-home-editor-header">
        <p class="ca-admin-section__description">
            Kelola identitas CarAsset, visi dan misi, legalitas, partner, FAQ, serta konten form kontak tanpa mengubah struktur desain publik.
        </p>
        <x-admin::button :href="route('about-contact')" target="_blank" variant="outline" size="sm" icon="external-link">
            Lihat Halaman Tentang & Kontak
        </x-admin::button>
    </div>

    <div class="ca-admin-workflow-page-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Perubahan yang disimpan akan menjadi Draft. Website publik hanya berubah setelah Draft dipublikasikan.
    </div>

    <div class="ca-admin-home-editor-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Pada tahap ini form kontak hanya dikelola dari sisi konten. Pengiriman form dan Pesan Masuk akan diaktifkan pada tahap berikutnya.
    </div>

    <div class="ca-admin-home-editor">
        <nav class="ca-admin-home-nav" aria-label="Navigasi section Tentang & Kontak">
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

                    @if ($key === 'legal-partners')
                        <p class="ca-admin-legal-notice">
                            <span data-lucide="alert-triangle" aria-hidden="true"></span>
                            Sistem tidak memverifikasi legalitas atau hubungan partner. Masukkan hanya data yang telah memperoleh persetujuan resmi.
                        </p>
                    @endif

                    <form method="POST" action="{{ route('admin.pages.about-contact.sections.update', $key) }}" class="ca-admin-home-form" data-about-contact-section-form>
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
    <script src="{{ asset('assets/admin/js/admin-about-contact-editor.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-content-workflow.js') }}" defer></script>
@endpush
