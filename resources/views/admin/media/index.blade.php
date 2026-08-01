@extends('admin.layouts.app')

@section('title', 'Media Library — Panel Admin CarAsset')
@section('page-title', 'Media Library')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Media Library'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-media.css') }}">
@endpush

@section('content')
    <section class="ca-admin-section">
        <div class="ca-admin-media-toolbar">
            <div>
                <p class="ca-admin-section__description">
                    Kelola gambar yang digunakan pada konten dan pengaturan website CarAsset.
                </p>
            </div>

            <x-admin::button :href="route('admin.media.create')" variant="primary" icon="upload">
                Upload Media
            </x-admin::button>
        </div>

        <form method="GET" action="{{ route('admin.media.index') }}" class="ca-admin-media-search" role="search">
            <label for="media-search" class="ca-admin-visually-hidden">Cari media</label>
            <input
                type="search"
                id="media-search"
                name="search"
                class="ca-admin-field__control"
                placeholder="Cari berdasarkan nama file, alt text, atau caption..."
                value="{{ $search }}"
            >
            <x-admin::button type="submit" variant="outline" size="sm" icon="search">Cari</x-admin::button>
        </form>

        @if ($media->isEmpty())
            <x-admin::empty-state
                icon="image-off"
                title="Belum Ada Media"
                description="Upload gambar pertama untuk digunakan pada pengaturan dan konten website CarAsset."
            >
                <x-slot:action>
                    <x-admin::button :href="route('admin.media.create')" variant="primary" icon="upload">
                        Upload Media
                    </x-admin::button>
                </x-slot:action>
            </x-admin::empty-state>
        @else
            <div class="ca-admin-media-grid">
                @foreach ($media as $item)
                    <div class="ca-admin-media-card">
                        <a href="{{ route('admin.media.edit', $item) }}" class="ca-admin-media-card__preview">
                            @if ($item->url())
                                <img src="{{ $item->url() }}" alt="{{ $item->alt_text }}" loading="lazy">
                            @else
                                <span class="ca-admin-media-card__missing" data-lucide="image-off" aria-hidden="true"></span>
                            @endif
                        </a>

                        <div class="ca-admin-media-card__body">
                            <p class="ca-admin-media-card__name" title="{{ $item->original_name }}">{{ $item->original_name }}</p>
                            <p class="ca-admin-media-card__meta">
                                {{ strtoupper(pathinfo($item->file_name, PATHINFO_EXTENSION)) }}
                                &middot; {{ $item->formattedFileSize() }}
                                @if ($item->dimensionsLabel())
                                    &middot; {{ $item->dimensionsLabel() }}
                                @endif
                            </p>
                            <p class="ca-admin-media-card__meta">
                                {{ $item->created_at->translatedFormat('d M Y') }}
                                @if ($item->uploader)
                                    &middot; {{ $item->uploader->name }}
                                @endif
                            </p>

                            <div class="ca-admin-media-card__footer">
                                @if (in_array($item->id, $usedMediaIds, true))
                                    <x-admin::status-badge variant="active">Digunakan</x-admin::status-badge>
                                @else
                                    <x-admin::status-badge variant="neutral">Tidak Digunakan</x-admin::status-badge>
                                @endif

                                <x-admin::button :href="route('admin.media.edit', $item)" variant="ghost" size="sm">
                                    Lihat/Edit
                                </x-admin::button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($media->hasPages())
                <nav aria-label="Navigasi halaman media" class="ca-admin-pagination">
                    @if ($media->onFirstPage())
                        <span class="ca-admin-pagination__link is-disabled">Sebelumnya</span>
                    @else
                        <a href="{{ $media->previousPageUrl() }}" class="ca-admin-pagination__link">Sebelumnya</a>
                    @endif

                    <span class="ca-admin-pagination__info">
                        Halaman {{ $media->currentPage() }} dari {{ $media->lastPage() }}
                    </span>

                    @if ($media->hasMorePages())
                        <a href="{{ $media->nextPageUrl() }}" class="ca-admin-pagination__link">Berikutnya</a>
                    @else
                        <span class="ca-admin-pagination__link is-disabled">Berikutnya</span>
                    @endif
                </nav>
            @endif
        @endif
    </section>
@endsection
