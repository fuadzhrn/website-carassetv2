<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'CarAsset — Mobil Bekerja. Aset Bertumbuh.')</title>
<meta name="description" content="@yield('meta_description', 'CarAsset membantu mengelola kendaraan produktif melalui sistem kemitraan yang profesional dan transparan.')">
<meta name="robots" content="index, follow">
<meta name="theme-color" content="#0F172A">

<link rel="canonical" href="{{ url()->current() }}">

{{-- Favicon resmi (public/assets/images/brand/favicon.png) menunggu file dari klien.
     Selama belum tersedia, gunakan favicon bawaan Laravel agar tidak broken. --}}
@if (file_exists(public_path('assets/images/brand/favicon.png')))
    <link rel="icon" href="{{ asset('assets/images/brand/favicon.png') }}">
@else
    <link rel="icon" href="{{ asset('favicon.ico') }}">
@endif

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@500;600;700&family=Poppins:wght@400;500;600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
