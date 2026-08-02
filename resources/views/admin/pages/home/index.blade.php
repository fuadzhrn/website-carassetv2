@extends('admin.layouts.app')

@section('title', 'Home — Panel Admin CarAsset')
@section('page-title', 'Home')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website', 'route' => route('admin.pages.index')],
        ['label' => 'Home'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-home-editor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-content-workflow.css') }}">
@endpush

@php
    $sectionLabels = [
        'hero' => 'Hero & Value Proposition',
        'income-opportunity' => 'Pentingnya Penghasilan Tambahan',
        'process-summary' => 'Cara Singkat CarAsset Bekerja',
        'partnership-choice' => 'Pilihan Program Kemitraan',
        'consultation-cta' => 'CTA Konsultasi',
    ];

    $sectionFormViews = [
        'hero' => 'admin.pages.home.sections.hero-form',
        'income-opportunity' => 'admin.pages.home.sections.income-opportunity-form',
        'process-summary' => 'admin.pages.home.sections.process-summary-form',
        'partnership-choice' => 'admin.pages.home.sections.partnership-choice-form',
        'consultation-cta' => 'admin.pages.home.sections.consultation-cta-form',
    ];
@endphp

@section('content')
    <div class="ca-admin-home-editor-header">
        <p class="ca-admin-section__description">
            Kelola konten lima section halaman Home tanpa mengubah struktur desain publik.
        </p>
        <x-admin::button :href="route('home')" target="_blank" variant="outline" size="sm" icon="external-link">
            Lihat Home Publik
        </x-admin::button>
    </div>

    <div class="ca-admin-workflow-page-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Perubahan yang disimpan akan menjadi Draft. Website publik hanya berubah setelah Draft dipublikasikan.
    </div>

    <div class="ca-admin-home-editor">
        <nav class="ca-admin-home-nav" aria-label="Navigasi section Home">
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

                    <form method="POST" action="{{ route('admin.pages.home.sections.update', $key) }}" class="ca-admin-home-form" data-home-section-form>
                        @csrf
                        @method('PATCH')

                        <x-admin::form.checkbox
                            name="is_active"
                            value="1"
                            :checked="$isActive"
                            label="Tampilkan section pada halaman Home"
                        />

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
    <script src="{{ asset('assets/admin/js/admin-home-editor.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-content-workflow.js') }}" defer></script>
@endpush
