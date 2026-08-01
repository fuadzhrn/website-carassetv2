@php
    $user = auth()->user();
    $initials = collect(explode(' ', trim($user->name)))
        ->filter()
        ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

<div class="ca-admin-topbar__left">
    <button
        type="button"
        class="ca-admin-topbar__toggle"
        data-sidebar-toggle
        aria-label="Ciutkan atau perluas sidebar"
        aria-expanded="true"
        aria-controls="admin-sidebar"
    >
        <span data-lucide="panel-left" aria-hidden="true"></span>
    </button>

    <div class="ca-admin-topbar__titles">
        <h1 class="ca-admin-topbar__page-title">@yield('page-title', 'Panel Admin')</h1>
        @hasSection('breadcrumbs')
            @yield('breadcrumbs')
        @else
            <x-admin::breadcrumb :items="[['label' => 'Dashboard']]" />
        @endif
    </div>
</div>

<div class="ca-admin-topbar__right">
    <x-admin::button :href="route('home')" target="_blank" variant="outline" size="sm" icon="external-link">
        Lihat Website
    </x-admin::button>

    <a href="{{ route('admin.profile.edit') }}" class="ca-admin-topbar__user">
        <span class="ca-admin-topbar__avatar" aria-hidden="true">{{ $initials ?: '?' }}</span>
        <span class="ca-admin-topbar__user-info">
            <span class="ca-admin-topbar__user-name">{{ $user->name }}</span>
            <span class="ca-admin-topbar__user-role">Administrator</span>
        </span>
    </a>
</div>
