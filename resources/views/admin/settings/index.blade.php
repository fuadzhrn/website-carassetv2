@extends('admin.layouts.app')

@section('title', 'Pengaturan Website — Panel Admin CarAsset')
@section('page-title', 'Pengaturan Website')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Pengaturan Website'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-settings.css') }}">
@endpush

@section('content')
    <p class="ca-admin-section__description">
        Kelola identitas brand, informasi kontak, footer, media sosial, dan SEO default CarAsset.
    </p>

    <div class="ca-admin-settings-shell">
        <nav class="ca-admin-settings-rail" aria-label="Navigasi kelompok pengaturan">
            @foreach ($groups as $groupKey => $groupData)
                <a href="#{{ $groupKey }}" class="ca-admin-settings-rail__link">{{ $groupData['label'] }}</a>
            @endforeach
        </nav>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="ca-admin-settings-form" data-settings-form novalidate>
            @csrf
            @method('PATCH')

            @foreach ($groups as $groupKey => $groupData)
                <section id="{{ $groupKey }}" class="ca-admin-settings-group">
                    <h2 class="ca-admin-settings-group__title">{{ $groupData['label'] }}</h2>

                    @foreach ($groupData['fields'] as $fieldKey => $fieldData)
                        @php
                            $flatKey = "{$groupKey}.{$fieldKey}";
                            // Nama untuk error bag Laravel (settings.brand.name) — HARUS cocok
                            // dengan key nested array settings[brand][name] yang divalidasi.
                            $errorKey = "settings.{$groupKey}.{$fieldKey}";
                            $inputName = "settings[{$groupKey}][{$fieldKey}]";
                            $currentValue = $values[$flatKey] ?? $fieldData['default'] ?? null;
                            $isRequired = in_array('required', $fieldData['rules'], true);
                        @endphp

                        @if ($fieldData['type'] === 'media')
                            <x-admin::media-picker
                                :name="$inputName"
                                :label="$fieldData['label']"
                                :selected-media="$mediaFieldValues[$flatKey] ?? null"
                                :media-items="$recentMedia"
                                :required="$isRequired"
                                helper="Kosongkan untuk memakai aset bawaan CarAsset."
                            />
                        @elseif ($fieldData['type'] === 'textarea')
                            <x-admin::form.field :name="$errorKey" :label="$fieldData['label']" :required="$isRequired">
                                <x-admin::form.textarea :name="$inputName" :error-key="$errorKey" rows="4" :value="$currentValue" />
                            </x-admin::form.field>
                        @elseif ($fieldData['type'] === 'select')
                            <x-admin::form.field :name="$errorKey" :label="$fieldData['label']" :required="$isRequired">
                                <x-admin::form.select :name="$inputName" :error-key="$errorKey" :options="$fieldData['options']" :selected="$currentValue" />
                            </x-admin::form.field>
                        @else
                            <x-admin::form.field :name="$errorKey" :label="$fieldData['label']" :required="$isRequired">
                                <x-admin::form.input
                                    :name="$inputName"
                                    :error-key="$errorKey"
                                    :type="$fieldData['type'] === 'phone' ? 'text' : ($fieldData['type'] === 'url' ? 'url' : $fieldData['type'])"
                                    :value="$currentValue"
                                />
                            </x-admin::form.field>
                        @endif
                    @endforeach
                </section>
            @endforeach

            <div class="ca-admin-settings-actionbar" data-settings-actionbar>
                <span class="ca-admin-settings-actionbar__status" data-settings-status hidden>
                    Ada perubahan yang belum disimpan.
                </span>
                <x-admin::button type="submit" variant="primary" icon="save">Simpan Pengaturan</x-admin::button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/media-picker.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/site-settings.js') }}" defer></script>
@endpush
