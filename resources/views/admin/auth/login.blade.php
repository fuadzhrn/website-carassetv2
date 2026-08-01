@extends('admin.layouts.auth')

@section('title', 'Masuk ke Panel Admin — CarAsset')

@section('content')
<div class="ca-admin-auth">
    <div class="ca-admin-auth__shell">

        {{-- EDITORIAL — Secure Mobility Gateway --}}
        <div class="ca-admin-auth__editorial">
            <div class="ca-admin-auth__grid" aria-hidden="true"></div>
            <div class="ca-admin-auth__route" aria-hidden="true">
                <svg viewBox="0 0 600 800" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M -20 620 C 120 620, 160 480, 280 460 S 460 340, 460 220 S 380 60, 520 -20"
                          fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="2 14" stroke-linecap="round"/>
                </svg>
                <span class="ca-admin-auth__route-node ca-admin-auth__route-node--1" aria-hidden="true"></span>
                <span class="ca-admin-auth__route-node ca-admin-auth__route-node--2" aria-hidden="true"></span>
                <span class="ca-admin-auth__route-node ca-admin-auth__route-node--3" aria-hidden="true"></span>
            </div>

            <div class="ca-admin-auth__editorial-inner">
                <div class="ca-admin-auth__brand">
                    @if (file_exists(public_path('assets/images/brand/logo-on-dark.png')))
                        <img src="{{ asset('assets/images/brand/logo-on-dark.png') }}" alt="CarAsset" class="ca-admin-auth__brand-logo">
                    @else
                        <span class="ca-admin-auth__brand-fallback">CarAsset</span>
                    @endif
                </div>

                <span class="ca-admin-auth__label">Area Administrator</span>

                <h1 class="ca-admin-auth__headline">
                    Kelola Konten.<br>
                    Jaga Konsistensi.
                </h1>

                <p class="ca-admin-auth__description">
                    Akses panel terstruktur untuk memperbarui informasi website CarAsset
                    tanpa mengubah fondasi desainnya.
                </p>

                <div class="ca-admin-auth__checkpoints" aria-hidden="true">
                    <div class="ca-admin-auth__checkpoint">
                        <span class="ca-admin-auth__checkpoint-icon" data-lucide="log-in"></span>
                        <span class="ca-admin-auth__checkpoint-label">Akses</span>
                    </div>
                    <span class="ca-admin-auth__checkpoint-divider"></span>
                    <div class="ca-admin-auth__checkpoint">
                        <span class="ca-admin-auth__checkpoint-icon" data-lucide="shield-check"></span>
                        <span class="ca-admin-auth__checkpoint-label">Verifikasi</span>
                    </div>
                    <span class="ca-admin-auth__checkpoint-divider"></span>
                    <div class="ca-admin-auth__checkpoint">
                        <span class="ca-admin-auth__checkpoint-icon" data-lucide="panels-top-left"></span>
                        <span class="ca-admin-auth__checkpoint-label">Kelola</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- PORTAL — login panel --}}
        <div class="ca-admin-auth__portal">
            <div class="ca-admin-auth__panel">
                <span class="ca-admin-auth__panel-label">Secure Content Gateway</span>
                <h2 class="ca-admin-auth__title">Masuk ke Panel Admin</h2>
                <p class="ca-admin-auth__panel-description">Gunakan akun administrator yang telah terdaftar.</p>

                @if (session('status'))
                    <div class="ca-admin-auth__notice" role="status">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="ca-admin-auth__error" role="alert">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('admin.login.attempt') }}" class="ca-admin-auth__form" novalidate>
                    @csrf

                    <div class="ca-admin-field">
                        <label for="login" class="ca-admin-field__label">Email atau Username</label>
                        <input
                            type="text"
                            id="login"
                            name="login"
                            class="ca-admin-field__control"
                            value="{{ old('login') }}"
                            required
                            autocomplete="username"
                            autofocus
                        >
                    </div>

                    <div class="ca-admin-field">
                        <label for="password" class="ca-admin-field__label">Password</label>
                        <div class="ca-admin-field__control-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="ca-admin-field__control"
                                required
                                autocomplete="current-password"
                                data-password-input
                            >
                            <button
                                type="button"
                                class="ca-admin-field__toggle"
                                data-password-toggle
                                aria-pressed="false"
                                aria-label="Tampilkan password"
                            >
                                <span data-lucide="eye" data-icon-show aria-hidden="true"></span>
                                <span data-lucide="eye-off" data-icon-hide aria-hidden="true" hidden></span>
                            </button>
                        </div>
                        <p class="ca-admin-field__capslock" data-capslock-indicator aria-live="polite" hidden>
                            Caps Lock sedang aktif.
                        </p>
                    </div>

                    <button type="submit" class="ca-admin-auth__submit" data-submit-button>
                        <span data-submit-label>Masuk ke Panel Admin</span>
                    </button>
                </form>

                <a href="{{ route('home') }}" class="ca-admin-auth__back">
                    <span data-lucide="arrow-left" aria-hidden="true"></span>
                    Kembali ke Website CarAsset
                </a>

                <p class="ca-admin-auth__footnote">Akses terbatas untuk pengelola resmi CarAsset.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/admin-login.js') }}" defer></script>
@endpush
