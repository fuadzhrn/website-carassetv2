@php
    $user = auth()->user();
@endphp

<div class="ca-admin-sidebar__brand">
    <a href="{{ route('admin.dashboard') }}" class="ca-admin-sidebar__brand-link">
        @if (file_exists(public_path('assets/images/brand/logo-on-dark.png')))
            <img src="{{ asset('assets/images/brand/logo-on-dark.png') }}" alt="CarAsset" class="ca-admin-sidebar__brand-logo">
        @else
            <span class="ca-admin-sidebar__brand-fallback">CarAsset</span>
        @endif
        <span class="ca-admin-sidebar__brand-mark" aria-hidden="true">CA</span>
    </a>
    <span class="ca-admin-sidebar__brand-label">CMS Administrator</span>
</div>

<nav class="ca-admin-sidebar__nav" aria-label="Navigasi administrator">
    <p class="ca-admin-sidebar__group-label">Utama</p>
    <ul class="ca-admin-sidebar__menu">
        <li>
            <a
                href="{{ route('admin.dashboard') }}"
                class="ca-admin-sidebar__link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"
                @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif
                title="Dashboard"
            >
                <span class="ca-admin-sidebar__link-icon" data-lucide="layout-dashboard" aria-hidden="true"></span>
                <span class="ca-admin-sidebar__link-label">Dashboard</span>
            </a>
        </li>
    </ul>

    <p class="ca-admin-sidebar__group-label {{ request()->routeIs('admin.pages.*') ? 'is-active' : '' }}">Konten Website</p>
    <ul class="ca-admin-sidebar__menu">
        @php
            $contentPages = [
                ['route' => 'admin.pages.index', 'label' => 'Semua Halaman', 'icon' => 'panels-top-left'],
                ['route' => 'admin.pages.home', 'label' => 'Home', 'icon' => 'house'],
                ['route' => 'admin.pages.business', 'label' => 'Bisnis CarAsset', 'icon' => 'briefcase-business'],
                ['route' => 'admin.pages.partnership', 'label' => 'Program Kemitraan', 'icon' => 'handshake'],
                ['route' => 'admin.pages.simulation', 'label' => 'Simulasi & Perlindungan', 'icon' => 'shield-check'],
                ['route' => 'admin.pages.about-contact', 'label' => 'Tentang & Kontak', 'icon' => 'building-2'],
            ];
        @endphp
        @foreach ($contentPages as $item)
            <li>
                <a
                    href="{{ route($item['route']) }}"
                    class="ca-admin-sidebar__link {{ request()->routeIs($item['route']) ? 'is-active' : '' }}"
                    @if (request()->routeIs($item['route'])) aria-current="page" @endif
                    title="{{ $item['label'] }}"
                >
                    <span class="ca-admin-sidebar__link-icon" data-lucide="{{ $item['icon'] }}" aria-hidden="true"></span>
                    <span class="ca-admin-sidebar__link-label">{{ $item['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <p class="ca-admin-sidebar__group-label">Pengelolaan</p>
    <ul class="ca-admin-sidebar__menu">
        @php
            $managementItems = [
                ['route' => 'admin.media.index', 'label' => 'Media Library', 'icon' => 'images'],
                ['route' => 'admin.seo.index', 'label' => 'SEO', 'icon' => 'search-check'],
                ['route' => 'admin.messages.index', 'match' => 'admin.messages.*', 'label' => 'Pesan Masuk', 'icon' => 'inbox'],
                ['route' => 'admin.settings.index', 'label' => 'Pengaturan Website', 'icon' => 'settings'],
            ];
        @endphp
        @foreach ($managementItems as $item)
            @php $isCurrent = request()->routeIs($item['match'] ?? $item['route']); @endphp
            <li>
                <a
                    href="{{ route($item['route']) }}"
                    class="ca-admin-sidebar__link {{ $isCurrent ? 'is-active' : '' }}"
                    @if ($isCurrent) aria-current="page" @endif
                    title="{{ $item['label'] }}"
                >
                    <span class="ca-admin-sidebar__link-icon" data-lucide="{{ $item['icon'] }}" aria-hidden="true"></span>
                    <span class="ca-admin-sidebar__link-label">{{ $item['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</nav>

<div class="ca-admin-sidebar__account">
    <div class="ca-admin-sidebar__user">
        <span class="ca-admin-sidebar__user-name">{{ $user->name }}</span>
        <span class="ca-admin-sidebar__user-email">{{ $user->username ?? $user->email }}</span>
    </div>

    <ul class="ca-admin-sidebar__menu">
        <li>
            <a
                href="{{ route('admin.profile.edit') }}"
                class="ca-admin-sidebar__link {{ request()->routeIs('admin.profile.*') ? 'is-active' : '' }}"
                @if (request()->routeIs('admin.profile.*')) aria-current="page" @endif
                title="Profil Admin"
            >
                <span class="ca-admin-sidebar__link-icon" data-lucide="circle-user-round" aria-hidden="true"></span>
                <span class="ca-admin-sidebar__link-label">Profil Admin</span>
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('admin.logout') }}" class="ca-admin-sidebar__logout-form">
                @csrf
                <button type="submit" class="ca-admin-sidebar__link ca-admin-sidebar__link--button" title="Keluar">
                    <span class="ca-admin-sidebar__link-icon" data-lucide="log-out" aria-hidden="true"></span>
                    <span class="ca-admin-sidebar__link-label">Keluar</span>
                </button>
            </form>
        </li>
    </ul>
</div>
