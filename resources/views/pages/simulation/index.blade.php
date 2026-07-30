@extends('layouts.app')

@section('title', 'Simulasi dan Perlindungan Aset CarAsset')

@section(
    'meta_description',
    'Pelajari contoh ilustrasi operasional, perbandingan skala unit, serta sistem perlindungan dan monitoring aset dalam program CarAsset.'
)

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
    @include('pages.simulation.sections.assumptions')
    @include('pages.simulation.sections.one-unit')
    @include('pages.simulation.sections.multiple-units')
    @include('pages.simulation.sections.protection-monitoring')
    @include('pages.simulation.sections.disclaimer')
@endsection

@push('scripts')
    {{-- simulation-config.js WAJIB dimuat sebelum simulation-render.js --}}
    <script src="{{ asset('assets/js/pages/simulation/simulation-config.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/simulation/simulation-render.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/simulation/monitoring-illustration.js') }}" defer></script>
@endpush
