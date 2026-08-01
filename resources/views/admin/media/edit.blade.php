@extends('admin.layouts.app')

@section('title', 'Edit Media — Panel Admin CarAsset')
@section('page-title', 'Edit Media')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Media Library', 'route' => route('admin.media.index')],
        ['label' => $media->original_name],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-media.css') }}">
@endpush

@section('content')
    <section class="ca-admin-section ca-admin-media-edit">
        {{-- PREVIEW + METADATA --}}
        <div class="ca-admin-media-detail">
            <div class="ca-admin-media-detail__preview">
                @if ($fileExists && $media->url())
                    <img src="{{ $media->url() }}" alt="{{ $media->alt_text }}">
                @else
                    <div class="ca-admin-media-detail__missing">
                        <span data-lucide="image-off" aria-hidden="true"></span>
                        <p>File tidak ditemukan di storage.</p>
                    </div>
                @endif
            </div>

            <dl class="ca-admin-media-meta">
                <div><dt>Nama Asli</dt><dd>{{ $media->original_name }}</dd></div>
                <div><dt>Nama File</dt><dd><code>{{ $media->file_name }}</code></dd></div>
                <div><dt>Format</dt><dd>{{ strtoupper(pathinfo($media->file_name, PATHINFO_EXTENSION)) }}</dd></div>
                <div><dt>MIME Type</dt><dd>{{ $media->mime_type }}</dd></div>
                <div><dt>Ukuran File</dt><dd>{{ $media->formattedFileSize() }}</dd></div>
                <div><dt>Dimensi</dt><dd>{{ $media->dimensionsLabel() ?? '—' }}</dd></div>
                <div><dt>Diunggah Oleh</dt><dd>{{ $media->uploader?->name ?? '—' }}</dd></div>
                <div><dt>Tanggal Upload</dt><dd>{{ $media->created_at->translatedFormat('d F Y, H:i') }}</dd></div>
                <div>
                    <dt>Status File</dt>
                    <dd>
                        @if ($fileExists)
                            <x-admin::status-badge variant="active">Tersedia</x-admin::status-badge>
                        @else
                            <x-admin::status-badge variant="inactive">Tidak Ditemukan</x-admin::status-badge>
                        @endif
                    </dd>
                </div>
                @if ($fileExists && $media->url())
                    <div><dt>URL Publik</dt><dd><code>{{ $media->url() }}</code></dd></div>
                @endif
            </dl>
        </div>

        {{-- METADATA FORM --}}
        <div class="ca-admin-media-form-card">
            <h2 class="ca-admin-table-card__title">Metadata</h2>

            <form method="POST" action="{{ route('admin.media.update', $media) }}" class="ca-admin-media-form">
                @csrf
                @method('PATCH')

                <x-admin::form.field name="alt_text" label="Alt Text" required>
                    <x-admin::form.input name="alt_text" value="{{ $media->alt_text }}" required maxlength="255" />
                </x-admin::form.field>

                <x-admin::form.field name="caption" label="Caption">
                    <x-admin::form.textarea name="caption" rows="3" maxlength="1000" :value="$media->caption" />
                </x-admin::form.field>

                <x-admin::button type="submit" variant="primary">Simpan Metadata</x-admin::button>
            </form>
        </div>

        {{-- USAGE --}}
        <div class="ca-admin-media-form-card">
            <h2 class="ca-admin-table-card__title">Penggunaan Media</h2>

            @if (empty($usages))
                <p class="ca-admin-section__description">Media ini belum digunakan di bagian mana pun pada website.</p>
            @else
                <ul class="ca-admin-media-usage-list">
                    @foreach ($usages as $usage)
                        <li class="ca-admin-media-usage-list__item">
                            <span class="ca-admin-media-usage-list__label">{{ $usage['label'] }}</span>
                            <code>{{ $usage['location'] }}</code>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- REPLACE FILE --}}
        <div class="ca-admin-media-form-card">
            <h2 class="ca-admin-table-card__title">Ganti File Gambar</h2>
            <p class="ca-admin-section__description">
                Mengganti file akan mempertahankan referensi media yang sudah digunakan.
            </p>

            <form method="POST" action="{{ route('admin.media.replace', $media) }}" enctype="multipart/form-data" class="ca-admin-media-form" data-media-upload-form>
                @csrf
                @method('PUT')

                <x-admin::form.field name="file" label="File Gambar Baru" required>
                    <input
                        type="file"
                        name="file"
                        id="file"
                        accept="image/jpeg,image/png,image/webp"
                        class="ca-admin-field__control"
                        required
                        data-media-file-input
                    >
                </x-admin::form.field>

                <div class="ca-admin-media-preview" data-media-preview hidden>
                    <img data-media-preview-image alt="">
                </div>

                <x-admin::button type="submit" variant="secondary" icon="repeat">Ganti File</x-admin::button>
            </form>
        </div>

        {{-- DELETE --}}
        <div class="ca-admin-media-form-card ca-admin-media-form-card--danger">
            <h2 class="ca-admin-table-card__title">Hapus Media</h2>

            @if (! empty($usages))
                <p class="ca-admin-media-usage-warning">
                    Media tidak dapat dihapus karena masih digunakan pada bagian website.
                </p>
                <x-admin::button variant="danger" disabled>Hapus Media</x-admin::button>
            @else
                <p class="ca-admin-section__description">
                    Tindakan ini akan menghapus file dan record media secara permanen.
                </p>
                <x-admin::button type="button" variant="danger" icon="trash-2" data-open-delete-modal>
                    Hapus Media
                </x-admin::button>

                <dialog id="delete-media-modal" class="ca-admin-modal" data-delete-modal>
                    <div class="ca-admin-modal__inner">
                        <h2 class="ca-admin-modal__title">Hapus media ini?</h2>
                        <p class="ca-admin-modal__description">
                            "{{ $media->original_name }}" akan dihapus permanen dan tidak dapat dikembalikan.
                        </p>
                        <div class="ca-admin-modal__actions">
                            <x-admin::button type="button" variant="ghost" data-close-delete-modal>Batal</x-admin::button>
                            <form method="POST" action="{{ route('admin.media.destroy', $media) }}">
                                @csrf
                                @method('DELETE')
                                <x-admin::button type="submit" variant="danger">Ya, Hapus</x-admin::button>
                            </form>
                        </div>
                    </div>
                </dialog>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/media-library.js') }}" defer></script>
@endpush
