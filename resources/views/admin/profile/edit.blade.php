@extends('admin.layouts.app')

@section('title', 'Profil Admin — Panel Admin CarAsset')
@section('page-title', 'Profil Admin')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Profil Admin'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-profile.css') }}">
@endpush

@section('content')
<div class="ca-admin-profile">
    <p class="ca-admin-profile__subtitle">Perbarui informasi akun dan kelola password login Anda.</p>

    <div class="ca-admin-profile__grid">
        {{-- FORM PROFIL --}}
        <section class="ca-admin-profile__card">
            <h2 class="ca-admin-profile__card-title">Informasi Akun</h2>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="ca-admin-profile__form">
                @csrf
                @method('PATCH')

                <x-admin::form.field name="name" label="Nama" required>
                    <x-admin::form.input name="name" value="{{ auth()->user()->name }}" required />
                </x-admin::form.field>

                <x-admin::form.field name="email" label="Email" required>
                    <x-admin::form.input name="email" type="email" value="{{ auth()->user()->email }}" required />
                </x-admin::form.field>

                <x-admin::form.field name="username" label="Username">
                    <x-admin::form.input name="username" value="{{ auth()->user()->username }}" />
                </x-admin::form.field>

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

                <x-admin::button type="submit" variant="primary">Simpan Perubahan</x-admin::button>
            </form>
        </section>

        {{-- FORM GANTI PASSWORD --}}
        <section class="ca-admin-profile__card">
            <h2 class="ca-admin-profile__card-title">Ganti Password</h2>

            <form method="POST" action="{{ route('admin.password.update') }}" class="ca-admin-profile__form">
                @csrf
                @method('PUT')

                <x-admin::form.field name="current_password" label="Password Saat Ini" required>
                    <x-admin::form.input name="current_password" type="password" autocomplete="current-password" required />
                </x-admin::form.field>

                <x-admin::form.field name="password" label="Password Baru" required helper="Minimal 10 karakter.">
                    <x-admin::form.input name="password" type="password" autocomplete="new-password" required />
                </x-admin::form.field>

                <x-admin::form.field name="password_confirmation" label="Konfirmasi Password Baru" required>
                    <x-admin::form.input name="password_confirmation" type="password" autocomplete="new-password" required />
                </x-admin::form.field>

                <x-admin::button type="submit" variant="primary">Perbarui Password</x-admin::button>
            </form>
        </section>
    </div>
</div>
@endsection
