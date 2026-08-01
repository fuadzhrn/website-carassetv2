@extends('admin.layouts.app')

@section('title', 'Dashboard — Panel Admin CarAsset')
@section('page-title', 'Dashboard')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[['label' => 'Dashboard']]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-dashboard.css') }}">
@endpush

@section('content')
    {{-- SECTION 1 — WELCOME PANEL --}}
    <section class="ca-admin-welcome">
        <div class="ca-admin-welcome__main">
            <h2 class="ca-admin-welcome__title">Selamat Datang, {{ auth()->user()->name }}</h2>
            <p class="ca-admin-welcome__description">
                Gunakan panel ini untuk mengelola konten website CarAsset secara terstruktur
                tanpa mengubah fondasi desain publik.
            </p>

            <div class="ca-admin-welcome__meta">
                <span class="ca-admin-welcome__meta-item">
                    <span data-lucide="shield-check" aria-hidden="true"></span>
                    Role: Administrator
                </span>
                <span class="ca-admin-welcome__meta-item">
                    <span data-lucide="circle-check" aria-hidden="true"></span>
                    Autentikasi Aktif
                </span>
                @if (auth()->user()->last_login_at)
                    <span class="ca-admin-welcome__meta-item">
                        <span data-lucide="clock" aria-hidden="true"></span>
                        Login terakhir: {{ auth()->user()->last_login_at->translatedFormat('d F Y, H:i') }} WIB
                    </span>
                @endif
            </div>
        </div>

        <div class="ca-admin-welcome__actions">
            <x-admin::button :href="route('admin.profile.edit')" variant="primary" icon="circle-user-round">
                Edit Profil
            </x-admin::button>
            <x-admin::button :href="route('home')" target="_blank" variant="outline" icon="external-link">
                Lihat Website
            </x-admin::button>
        </div>
    </section>

    {{-- SECTION 2 — QUICK ACCESS --}}
    <section class="ca-admin-section">
        <h2 class="ca-admin-section__title">Akses Konten Website</h2>

        <div class="ca-admin-quick-access">
            @foreach ($quickAccessPages as $item)
                <div class="ca-admin-quick-access__item">
                    <div class="ca-admin-quick-access__info">
                        <p class="ca-admin-quick-access__title">{{ $item['title'] }}</p>
                        <p class="ca-admin-quick-access__description">{{ $item['description'] }}</p>
                    </div>

                    <x-admin::status-badge variant="pending">Belum terhubung ke CMS</x-admin::status-badge>

                    <x-admin::button :href="route($item['route'])" variant="ghost" size="sm" icon="arrow-right">
                        Buka Workspace
                    </x-admin::button>
                </div>
            @endforeach
        </div>
    </section>

    {{-- SECTION 3 — STATUS IMPLEMENTASI --}}
    <section class="ca-admin-section">
        <h2 class="ca-admin-section__title">Status Implementasi</h2>

        <ul class="ca-admin-status-list">
            <li class="ca-admin-status-list__item">
                <span>Autentikasi Admin</span>
                <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
            </li>
            <li class="ca-admin-status-list__item">
                <span>Layout Admin</span>
                <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
            </li>
            <li class="ca-admin-status-list__item">
                <span>Database CMS</span>
                <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
            </li>
            <li class="ca-admin-status-list__item">
                <span>Content Service</span>
                <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
            </li>
            <li class="ca-admin-status-list__item">
                <span>Media Library</span>
                <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
            </li>
            <li class="ca-admin-status-list__item">
                <span>Home Editor</span>
                <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
            </li>
            <li class="ca-admin-status-list__item">
                <span>Bisnis Editor</span>
                <x-admin::status-badge variant="active">Aktif</x-admin::status-badge>
            </li>
            <li class="ca-admin-status-list__item">
                <span>Editor Program Kemitraan</span>
                <x-admin::status-badge variant="pending">Belum Tersedia</x-admin::status-badge>
            </li>
            <li class="ca-admin-status-list__item">
                <span>Draft &amp; Publish</span>
                <x-admin::status-badge variant="pending">Belum Tersedia</x-admin::status-badge>
            </li>
        </ul>
    </section>

    {{-- SECTION 4 — PANDUAN SINGKAT --}}
    <section class="ca-admin-section">
        <h2 class="ca-admin-section__title">Panduan Singkat</h2>

        <ol class="ca-admin-guide">
            <li>Pilih halaman yang ingin dikelola.</li>
            <li>Buka section yang ingin diperbarui.</li>
            <li>Simpan dan tinjau perubahan sebelum publikasi.</li>
        </ol>

        <p class="ca-admin-guide__note">
            Editor konten akan tersedia setelah fondasi database CMS selesai.
        </p>
    </section>
@endsection
