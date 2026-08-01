@extends('admin.layouts.app')

@section('title', 'Upload Media — Panel Admin CarAsset')
@section('page-title', 'Upload Media')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Media Library', 'route' => route('admin.media.index')],
        ['label' => 'Upload Media'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-media.css') }}">
@endpush

@section('content')
    <section class="ca-admin-section">
        <div class="ca-admin-media-form-card">
            <p class="ca-admin-media-form-info">
                Format diterima: JPG, JPEG, PNG, WebP.
                Ukuran maksimal: {{ number_format(config('media.max_size_kb') / 1024, 1) }} MB.
                Gambar disimpan pada Media Library dan dapat digunakan di pengaturan maupun konten website.
            </p>

            <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="ca-admin-media-form" data-media-upload-form>
                @csrf

                <x-admin::form.field name="file" label="Gambar" required>
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

                <x-admin::form.field name="alt_text" label="Alt Text" required helper="Digunakan untuk aksesibilitas — jelaskan isi gambar secara singkat.">
                    <x-admin::form.input name="alt_text" required maxlength="255" />
                </x-admin::form.field>

                <x-admin::form.field name="caption" label="Caption" helper="Opsional.">
                    <x-admin::form.textarea name="caption" rows="3" maxlength="1000" />
                </x-admin::form.field>

                <div class="ca-admin-media-form__actions">
                    <x-admin::button type="submit" variant="primary" icon="upload">Upload Media</x-admin::button>
                    <x-admin::button :href="route('admin.media.index')" variant="ghost">Kembali ke Media Library</x-admin::button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/media-library.js') }}" defer></script>
@endpush
