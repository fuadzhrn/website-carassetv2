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

    {{-- Token desain brand (warna/font/spacing) — dipakai bersama publik agar panel admin tetap konsisten visual --}}
    <link rel="stylesheet" href="{{ asset('assets/css/base/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/variables.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-auth.css') }}">

    @stack('styles')
</head>
<body class="ca-admin-body">
    @yield('content')

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer></script>
    <script src="{{ asset('assets/admin/js/admin-lucide-init.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
