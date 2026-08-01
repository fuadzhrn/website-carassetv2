@extends('admin.layouts.minimal')

@section('title', 'Profil Admin — Panel Admin CarAsset')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-profile.css') }}">
@endpush

@section('content')
<div class="ca-admin-profile">
    <a href="{{ route('admin.dashboard') }}" class="ca-admin-profile__back">
        <span data-lucide="arrow-left" aria-hidden="true"></span>
        Kembali ke Dashboard
    </a>

    <h1 class="ca-admin-profile__title">Profil Admin</h1>
    <p class="ca-admin-profile__subtitle">Perbarui informasi akun dan kelola password login Anda.</p>

    <div class="ca-admin-profile__grid">
        {{-- FORM PROFIL --}}
        <section class="ca-admin-profile__card">
            <h2 class="ca-admin-profile__card-title">Informasi Akun</h2>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="ca-admin-profile__form">
                @csrf
                @method('PATCH')

                <div class="ca-admin-field">
                    <label for="name" class="ca-admin-field__label">Nama</label>
                    <input type="text" id="name" name="name" class="ca-admin-field__control"
                           value="{{ old('name', auth()->user()->name) }}" required maxlength="100">
                    @error('name')
                        <p class="ca-admin-field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="ca-admin-field">
                    <label for="email" class="ca-admin-field__label">Email</label>
                    <input type="email" id="email" name="email" class="ca-admin-field__control"
                           value="{{ old('email', auth()->user()->email) }}" required maxlength="150">
                    @error('email')
                        <p class="ca-admin-field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="ca-admin-field">
                    <label for="username" class="ca-admin-field__label">Username</label>
                    <input type="text" id="username" name="username" class="ca-admin-field__control"
                           value="{{ old('username', auth()->user()->username) }}" maxlength="30">
                    @error('username')
                        <p class="ca-admin-field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="ca-admin-field ca-admin-field--readonly">
                    <span class="ca-admin-field__label">Role</span>
                    <span class="ca-admin-field__readonly-value">{{ auth()->user()->role }}</span>
                </div>

                <div class="ca-admin-field ca-admin-field--readonly">
                    <span class="ca-admin-field__label">Status Akun</span>
                    <span class="ca-admin-field__readonly-value">
                        {{ auth()->user()->isActive() ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <button type="submit" class="ca-admin-btn ca-admin-btn--primary">Simpan Perubahan</button>
            </form>
        </section>

        {{-- FORM GANTI PASSWORD --}}
        <section class="ca-admin-profile__card">
            <h2 class="ca-admin-profile__card-title">Ganti Password</h2>

            <form method="POST" action="{{ route('admin.password.update') }}" class="ca-admin-profile__form">
                @csrf
                @method('PUT')

                <div class="ca-admin-field">
                    <label for="current_password" class="ca-admin-field__label">Password Saat Ini</label>
                    <input type="password" id="current_password" name="current_password" class="ca-admin-field__control"
                           required autocomplete="current-password">
                    @error('current_password')
                        <p class="ca-admin-field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="ca-admin-field">
                    <label for="password" class="ca-admin-field__label">Password Baru</label>
                    <input type="password" id="password" name="password" class="ca-admin-field__control"
                           required autocomplete="new-password">
                    @error('password')
                        <p class="ca-admin-field__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="ca-admin-field">
                    <label for="password_confirmation" class="ca-admin-field__label">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="ca-admin-field__control"
                           required autocomplete="new-password">
                </div>

                <button type="submit" class="ca-admin-btn ca-admin-btn--primary">Perbarui Password</button>
            </form>
        </section>
    </div>
</div>
@endsection
