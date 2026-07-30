<header class="ca-header">
    <div class="ca-container ca-header__inner">
        <a href="{{ route('home') }}" class="ca-header__logo ca-card-title" aria-label="CarAsset — Beranda">
            {{-- Placeholder teks selama file logo resmi (public/assets/images/brand/logo-horizontal.png) belum tersedia --}}
            CarAsset
        </a>

        @include('partials.desktop-navigation')

        <x-button href="{{ route('partnership') }}" variant="primary" class="ca-header__cta">
            Konsultasi Sekarang
        </x-button>
    </div>
</header>
