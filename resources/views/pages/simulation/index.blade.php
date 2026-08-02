@extends('layouts.app')

{{-- Title/meta description now come from PageSeoService (see partials.seo-meta) --}}
@section('body-class', 'ca-page ca-page--simulation')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simulation/simulation.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simulation/assumptions.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simulation/one-unit.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simulation/multiple-units.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simulation/protection-monitoring.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simulation/disclaimer.css') }}">
@endpush

@section('content')
    @if ($simulation['assumptions']['is_active'])
        @include('pages.simulation.sections.assumptions', ['data' => $simulation['assumptions']])
    @endif

    @if ($simulation['one-unit']['is_active'])
        @include('pages.simulation.sections.one-unit', ['data' => $simulation['one-unit']])
    @endif

    @if ($simulation['multiple-units']['is_active'])
        @include('pages.simulation.sections.multiple-units', ['data' => $simulation['multiple-units']])
    @endif

    @if ($simulation['protection-monitoring']['is_active'])
        @include('pages.simulation.sections.protection-monitoring', ['data' => $simulation['protection-monitoring']])
    @endif

    @if ($simulation['disclaimer']['is_active'])
        @include('pages.simulation.sections.disclaimer', ['data' => $simulation['disclaimer']])
    @endif
@endsection

@push('scripts')
    {{--
        simulation-config.js dan simulation-render.js TIDAK dimuat lagi:
        keduanya menyuntikkan angka via JavaScript sisi klien, yang
        dilarang PROMPT 20 untuk data berstatus draft ("jangan menampilkan
        angka draft melalui JavaScript"). Sumber angka sekarang murni
        server-side (PageController + Blade), bukan overlay JS.
    --}}
    <script src="{{ asset('assets/js/pages/simulation/monitoring-illustration.js') }}" defer></script>
@endpush
