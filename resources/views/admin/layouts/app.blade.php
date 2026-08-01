<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Admin — CarAsset')</title>
    <meta name="robots" content="noindex, nofollow, noarchive">

    @if (file_exists(public_path('assets/images/brand/favicon.png')))
        <link rel="icon" href="{{ asset('assets/images/brand/favicon.png') }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@500;600;700&family=Poppins:wght@400;500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    {{-- Token desain brand — dipakai bersama publik agar panel admin tetap konsisten visual --}}
    <link rel="stylesheet" href="{{ asset('assets/css/base/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/variables.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-topbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-components.css') }}">

    @stack('styles')
</head>
<body class="ca-admin">
    <a href="#admin-main-content" class="ca-admin-skip-link">Lewati ke konten utama</a>

    <div class="ca-admin-shell">
        <aside id="admin-sidebar" class="ca-admin-sidebar">
            @include('admin.partials.sidebar')
        </aside>

        <div class="ca-admin-workspace">
            <header class="ca-admin-topbar">
                @include('admin.partials.topbar')
            </header>

            <main id="admin-main-content" class="ca-admin-main">
                <x-admin::flash-message />

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <script src="{{ asset('assets/admin/js/admin-lucide-init.js') }}" defer></script>
    <script src="{{ asset('assets/admin/js/admin-shell.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
