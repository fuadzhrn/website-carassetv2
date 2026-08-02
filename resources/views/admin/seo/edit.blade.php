@extends('admin.layouts.app')

@section('title', 'SEO — '.$pageMeta['name'].' — Panel Admin CarAsset')
@section('page-title', 'SEO — '.$pageMeta['name'])

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'SEO Per Halaman', 'route' => route('admin.seo.index')],
        ['label' => $pageMeta['name']],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-content-workflow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-seo.css') }}">
@endpush

@php
    $hasDraft = $page->hasSeoDraft();
@endphp

@section('content')
    <div class="ca-admin-seo-page-header">
        <p class="ca-admin-section__description">
            Atur metadata halaman tanpa mengubah slug, route, sitemap, atau struktur heading.
        </p>
        <x-admin::button :href="route($page->route_name)" target="_blank" variant="outline" size="sm" icon="external-link">
            Lihat Halaman Published
        </x-admin::button>
    </div>

    <div class="ca-admin-seo-identity">
        <div class="ca-admin-seo-identity__item">
            <span class="ca-admin-seo-identity__label">Nama Halaman</span>
            <span class="ca-admin-seo-identity__value">{{ $pageMeta['name'] }}</span>
        </div>
        <div class="ca-admin-seo-identity__item">
            <span class="ca-admin-seo-identity__label">Slug</span>
            <span class="ca-admin-seo-identity__value"><code>{{ $page->slug }}</code></span>
        </div>
        <div class="ca-admin-seo-identity__item">
            <span class="ca-admin-seo-identity__label">Route Name</span>
            <span class="ca-admin-seo-identity__value"><code>{{ $page->route_name }}</code></span>
        </div>
        <div class="ca-admin-seo-identity__item">
            <span class="ca-admin-seo-identity__label">URL Publik</span>
            <span class="ca-admin-seo-identity__value"><code>{{ route($page->route_name) }}</code></span>
        </div>
        <div class="ca-admin-seo-identity__item">
            <span class="ca-admin-seo-identity__label">Canonical Otomatis (bila dikosongkan)</span>
            <span class="ca-admin-seo-identity__value"><code>{{ $automaticCanonical }}</code></span>
        </div>
    </div>

    <x-admin::seo.seo-status :page="$page" />

    <div class="ca-admin-workflow-page-notice">
        <span data-lucide="info" aria-hidden="true"></span>
        Perubahan SEO yang disimpan akan menjadi Draft. Halaman publik hanya menggunakan SEO Published.
    </div>

    <div class="ca-admin-seo-workspace">
        <div class="ca-admin-seo-workspace__main">
            <form method="POST" action="{{ route('admin.seo.draft.update', $page->slug) }}" class="ca-admin-home-form" data-seo-form>
                @csrf
                @method('PATCH')

                <x-admin::form.field name="meta_title" label="Meta Title">
                    <x-admin::form.input name="meta_title" id="seo-meta-title" :value="$editorSeo['meta_title'] ?? ''" maxlength="{{ config('seo.title_max_length') }}" />
                </x-admin::form.field>
                <x-admin::seo.character-counter
                    input-id="seo-meta-title"
                    :value="old('meta_title', $editorSeo['meta_title'] ?? '')"
                    :recommended-min="config('seo.recommended_title_length.min')"
                    :recommended-max="config('seo.recommended_title_length.max')"
                    :max-length="config('seo.title_max_length')"
                />

                <x-admin::form.field name="meta_description" label="Meta Description">
                    <x-admin::form.textarea name="meta_description" id="seo-meta-description" :value="$editorSeo['meta_description'] ?? ''" maxlength="{{ config('seo.description_max_length') }}" rows="3" />
                </x-admin::form.field>
                <x-admin::seo.character-counter
                    input-id="seo-meta-description"
                    :value="old('meta_description', $editorSeo['meta_description'] ?? '')"
                    :recommended-min="config('seo.recommended_description_length.min')"
                    :recommended-max="config('seo.recommended_description_length.max')"
                    :max-length="config('seo.description_max_length')"
                />

                <fieldset class="ca-admin-data-status">
                    <legend class="ca-admin-cta-fields__legend">Robots</legend>
                    <div class="ca-admin-data-status__options">
                        <label class="ca-admin-data-status__option">
                            <input type="radio" name="meta_robots" id="seo-robots-index" value="index,follow" data-seo-robots-input @checked(old('meta_robots', $editorSeo['meta_robots'] ?? 'index,follow') === 'index,follow')>
                            Izinkan Pengindeksan
                        </label>
                        <label class="ca-admin-data-status__option">
                            <input type="radio" name="meta_robots" value="noindex,nofollow" data-seo-robots-input @checked(old('meta_robots', $editorSeo['meta_robots'] ?? 'index,follow') === 'noindex,nofollow')>
                            Jangan Indeks Halaman
                        </label>
                    </div>
                    @error('meta_robots')
                        <p class="ca-admin-field__error" role="alert">{{ $message }}</p>
                    @enderror
                </fieldset>

                <x-admin::form.field name="canonical_url" label="Canonical URL (opsional)" helper="Kosongkan untuk memakai URL route halaman secara otomatis.">
                    <x-admin::form.input name="canonical_url" id="seo-canonical-url" :value="$editorSeo['canonical_url'] ?? ''" maxlength="2048" placeholder="{{ $automaticCanonical }}" />
                </x-admin::form.field>

                <div class="ca-admin-home-form__actions">
                    <x-admin::button type="submit" variant="primary">Simpan Draft SEO</x-admin::button>
                </div>
            </form>

            <div class="ca-admin-section-action-bar">
                <a href="{{ $previewUrl }}" target="_blank" rel="noopener noreferrer" class="ca-admin-btn ca-admin-btn--outline ca-admin-btn--sm" data-seo-preview-link>
                    <span class="ca-admin-btn__icon" data-lucide="eye" aria-hidden="true"></span>
                    Preview Halaman
                </a>

                @if ($hasDraft)
                    <x-admin::confirm-dialog
                        id="seo-publish-{{ $page->slug }}"
                        title="Publikasikan SEO"
                        message="Draft SEO akan menggantikan SEO Published halaman ini."
                        :form-action="route('admin.seo.publish', $page->slug)"
                        form-method="PATCH"
                        confirm-label="Publish"
                        trigger-label="Publish SEO"
                        trigger-icon="upload-cloud"
                        variant="primary"
                    />

                    <x-admin::confirm-dialog
                        id="seo-discard-{{ $page->slug }}"
                        title="Batalkan Draft SEO"
                        message="Seluruh perubahan Draft SEO halaman ini akan dibuang. SEO Published tidak akan berubah."
                        :form-action="route('admin.seo.draft.discard', $page->slug)"
                        form-method="DELETE"
                        confirm-label="Batalkan Draft"
                        trigger-label="Batalkan Draft SEO"
                        trigger-icon="undo-2"
                    />
                @endif

                <x-admin::button :href="route('admin.seo.index')" variant="ghost" size="sm" icon="arrow-left">
                    Kembali ke Daftar SEO
                </x-admin::button>
            </div>
        </div>

        <div class="ca-admin-seo-workspace__side">
            <div class="ca-admin-seo-panel">
                <h2 class="ca-admin-seo-panel__title">Pratinjau Hasil Pencarian</h2>
                <x-admin::seo.seo-preview :seo="$previewSeo" />
            </div>

            <div class="ca-admin-seo-panel">
                <h2 class="ca-admin-seo-panel__title">Struktur Heading</h2>
                <p class="ca-admin-seo-panel__note">
                    Struktur heading dikelola melalui editor konten dan tidak dapat diubah dari modul SEO.
                </p>
            </div>

            <div class="ca-admin-seo-panel">
                <h2 class="ca-admin-seo-panel__title">Pemeriksaan Alt Text Gambar</h2>
                <x-admin::seo.image-alt-audit :rows="$imageAudit" />
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/admin-content-workflow.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-seo.js') }}" defer></script>
@endpush
