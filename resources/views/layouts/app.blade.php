<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.seo-meta')

    {{-- Urutan wajib: reset > variables > typography > utilities > global > layouts > components > pages --}}
    <link rel="stylesheet" href="{{ asset('assets/css/base/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/variables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/typography.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/utilities.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/base/global.css') }}">

    @stack('styles')
</head>
<body class="ca-body">
    @include('partials.header')

    <main class="ca-main">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp-button')

    @stack('scripts')
</body>
</html>
