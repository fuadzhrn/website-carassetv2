@php
    $brandName = $siteSettings['brand.name'] ?? 'CarAsset';
    $logoHorizontalSrc = $siteLogoHorizontalUrl ?? (file_exists(public_path('assets/images/brand/logo-horizontal.png'))
        ? asset('assets/images/brand/logo-horizontal.png')
        : null);
    $logoOnDarkSrc = $siteLogoOnDarkUrl ?? (file_exists(public_path('assets/images/brand/logo-on-dark.png'))
        ? asset('assets/images/brand/logo-on-dark.png')
        : null);
@endphp

<header class="ca-header {{ request()->routeIs('home') ? 'ca-header--overlay' : '' }}" data-header>
    <div class="ca-container ca-header__inner">
        <a href="{{ route('home') }}" class="ca-header__brand" aria-label="{{ $brandName }} — Beranda">
            {{-- Varian solid (default & setelah scroll di Home) --}}
            <span class="ca-header__logo ca-header__logo--solid">
                @if ($logoHorizontalSrc)
                    <img
                        src="{{ $logoHorizontalSrc }}"
                        alt="{{ $siteLogoHorizontalAlt ?? $brandName }}"
                        class="ca-header__logo-image"
                    >
                @else
                    {{-- Ganti dengan logo resmi CarAsset (public/assets/images/brand/logo-horizontal.png) --}}
                    <span class="ca-header__logo-fallback">
                        <span class="ca-header__logo-fallback-mark">CA</span>
                        <span class="ca-header__logo-fallback-text">
                            <span class="ca-header__logo-fallback-name">{{ $brandName }}</span>
                            <span class="ca-header__logo-fallback-tagline">Smart Asset Mobility</span>
                        </span>
                    </span>
                @endif
            </span>

            @if (request()->routeIs('home'))
                {{-- Varian terang (hanya di atas Hero Home, sebelum discroll) --}}
                <span class="ca-header__logo ca-header__logo--transparent">
                    @if ($logoOnDarkSrc)
                        <img
                            src="{{ $logoOnDarkSrc }}"
                            alt="{{ $siteLogoOnDarkAlt ?? $brandName }}"
                            class="ca-header__logo-image"
                        >
                    @else
                        {{-- Ganti dengan logo resmi CarAsset (public/assets/images/brand/logo-on-dark.png) --}}
                        <span class="ca-header__logo-fallback ca-header__logo-fallback--on-dark">
                            <span class="ca-header__logo-fallback-mark">CA</span>
                            <span class="ca-header__logo-fallback-text">
                                <span class="ca-header__logo-fallback-name">{{ $brandName }}</span>
                                <span class="ca-header__logo-fallback-tagline">Smart Asset Mobility</span>
                            </span>
                        </span>
                    @endif
                </span>
            @endif
        </a>

        <button
            type="button"
            class="ca-header__menu-toggle"
            data-mobile-menu-toggle
            data-label-open="Buka menu navigasi"
            data-label-close="Tutup menu navigasi"
            aria-expanded="false"
            aria-controls="ca-mobile-nav-panel"
        >
            <span class="ca-header__menu-icon ca-header__menu-icon--open" data-lucide="menu" aria-hidden="true"></span>
            <span class="ca-header__menu-icon ca-header__menu-icon--close" data-lucide="x" aria-hidden="true"></span>
        </button>

        <div class="ca-header__nav-panel" id="ca-mobile-nav-panel" data-mobile-nav-panel>
            @include('partials.desktop-navigation')

            <div class="ca-header__actions">
                <x-button href="{{ route('about-contact') }}#contact" variant="primary" size="md">
                    Konsultasi Sekarang
                </x-button>
            </div>
        </div>
    </div>
</header>

<div class="ca-header__overlay" data-mobile-nav-overlay aria-hidden="true"></div>
