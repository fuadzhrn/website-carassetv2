<header class="ca-header" data-header>
    <div class="ca-container ca-header__inner">
        <a href="{{ route('home') }}" class="ca-header__brand" aria-label="CarAsset — Beranda">
            @if (file_exists(public_path('assets/images/brand/logo-horizontal.png')))
                <img
                    src="{{ asset('assets/images/brand/logo-horizontal.png') }}"
                    alt="CarAsset"
                    class="ca-header__logo-image"
                >
            @else
                {{-- Ganti dengan logo resmi CarAsset (public/assets/images/brand/logo-horizontal.png) --}}
                <span class="ca-header__logo-fallback">
                    <span class="ca-header__logo-fallback-mark">CA</span>
                    <span class="ca-header__logo-fallback-text">
                        <span class="ca-header__logo-fallback-name">CarAsset</span>
                        <span class="ca-header__logo-fallback-tagline">Smart Asset Mobility</span>
                    </span>
                </span>
            @endif
        </a>

        @include('partials.desktop-navigation')

        <div class="ca-header__actions">
            <x-button href="{{ route('about-contact') }}#contact" variant="primary" size="md">
                Konsultasi Sekarang
            </x-button>
        </div>
    </div>
</header>
