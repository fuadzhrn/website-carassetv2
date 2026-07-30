<nav class="ca-nav" aria-label="Navigasi utama">
    <ul class="ca-nav__list">
        <li class="ca-nav__item">
            <a href="{{ route('home') }}" class="ca-nav__link ca-nav-text {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
        </li>
        <li class="ca-nav__item">
            <a href="{{ route('business') }}" class="ca-nav__link ca-nav-text {{ request()->routeIs('business') ? 'is-active' : '' }}">Bisnis CarAsset</a>
        </li>
        <li class="ca-nav__item">
            <a href="{{ route('partnership') }}" class="ca-nav__link ca-nav-text {{ request()->routeIs('partnership') ? 'is-active' : '' }}">Program Kemitraan</a>
        </li>
        <li class="ca-nav__item">
            <a href="{{ route('simulation') }}" class="ca-nav__link ca-nav-text {{ request()->routeIs('simulation') ? 'is-active' : '' }}">Simulasi & Perlindungan</a>
        </li>
        <li class="ca-nav__item">
            <a href="{{ route('about-contact') }}" class="ca-nav__link ca-nav-text {{ request()->routeIs('about-contact') ? 'is-active' : '' }}">Tentang & Kontak</a>
        </li>
    </ul>
</nav>
