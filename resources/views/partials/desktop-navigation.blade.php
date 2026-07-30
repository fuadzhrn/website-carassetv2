<nav class="ca-navigation" aria-label="Navigasi utama">
    <ul class="ca-navigation__list ca-list-reset">
        <li class="ca-navigation__item">
            <a
                href="{{ route('home') }}"
                class="ca-navigation__link ca-nav-text {{ request()->routeIs('home') ? 'ca-navigation__link--active' : '' }}"
                @if (request()->routeIs('home')) aria-current="page" @endif
            >Home</a>
        </li>
        <li class="ca-navigation__item">
            <a
                href="{{ route('business') }}"
                class="ca-navigation__link ca-nav-text {{ request()->routeIs('business') ? 'ca-navigation__link--active' : '' }}"
                @if (request()->routeIs('business')) aria-current="page" @endif
            >Bisnis CarAsset</a>
        </li>
        <li class="ca-navigation__item">
            <a
                href="{{ route('partnership') }}"
                class="ca-navigation__link ca-nav-text {{ request()->routeIs('partnership') ? 'ca-navigation__link--active' : '' }}"
                @if (request()->routeIs('partnership')) aria-current="page" @endif
            >Program Kemitraan</a>
        </li>
        <li class="ca-navigation__item">
            <a
                href="{{ route('simulation') }}"
                class="ca-navigation__link ca-nav-text {{ request()->routeIs('simulation') ? 'ca-navigation__link--active' : '' }}"
                @if (request()->routeIs('simulation')) aria-current="page" @endif
            >Simulasi & Perlindungan</a>
        </li>
        <li class="ca-navigation__item">
            <a
                href="{{ route('about-contact') }}"
                class="ca-navigation__link ca-nav-text {{ request()->routeIs('about-contact') ? 'ca-navigation__link--active' : '' }}"
                @if (request()->routeIs('about-contact')) aria-current="page" @endif
            >Tentang & Kontak</a>
        </li>
    </ul>
</nav>
