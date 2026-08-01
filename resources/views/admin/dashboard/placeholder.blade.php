@extends('admin.layouts.minimal')

@section('title', 'Dashboard Sementara — Panel Admin CarAsset')

@section('content')
<div class="ca-admin-placeholder">
    <span class="ca-admin-placeholder__badge">Fondasi Autentikasi Aktif</span>

    <h1 class="ca-admin-placeholder__title">Selamat Datang di Panel Admin CarAsset</h1>

    <p class="ca-admin-placeholder__text">
        Fondasi autentikasi telah aktif. Layout dan modul pengelolaan konten akan
        dibangun pada tahap berikutnya.
    </p>

    <dl class="ca-admin-placeholder__info">
        <div class="ca-admin-placeholder__info-row">
            <dt>Nama</dt>
            <dd>{{ auth()->user()->name }}</dd>
        </div>
        <div class="ca-admin-placeholder__info-row">
            <dt>Email</dt>
            <dd>{{ auth()->user()->email }}</dd>
        </div>
        @if (auth()->user()->username)
            <div class="ca-admin-placeholder__info-row">
                <dt>Username</dt>
                <dd>{{ auth()->user()->username }}</dd>
            </div>
        @endif
        @if (auth()->user()->last_login_at)
            <div class="ca-admin-placeholder__info-row">
                <dt>Login Terakhir</dt>
                <dd>{{ auth()->user()->last_login_at->translatedFormat('d F Y, H:i') }} WIB</dd>
            </div>
        @endif
    </dl>

    <div class="ca-admin-placeholder__actions">
        <a href="{{ route('admin.profile.edit') }}" class="ca-admin-btn ca-admin-btn--primary">
            Edit Profil
        </a>
        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="ca-admin-btn ca-admin-btn--ghost">
            Lihat Website
        </a>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="ca-admin-btn ca-admin-btn--danger">Logout</button>
        </form>
    </div>
</div>
@endsection
