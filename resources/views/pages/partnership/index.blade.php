@extends('layouts.app')

@section('title', 'Program Kemitraan CarAsset')

@section(
    'meta_description',
    'Pelajari program Mitra Owner dan Mitra Driver CarAsset serta pilihan skala kemitraan kendaraan produktif.'
)

@section('body-class', 'ca-page ca-page--partnership')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/partnership/partnership.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/partnership/program-selector.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/partnership/owner-program.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/partnership/driver-program.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/partnership/packages-benefits.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/partnership/terms.css') }}">
@endpush

@section('content')
    @if ($partnership['program-selector']['is_active'])
        @include('pages.partnership.sections.program-selector', ['data' => $partnership['program-selector']])
    @endif

    @if ($partnership['owner-program']['is_active'])
        @include('pages.partnership.sections.owner-program', ['data' => $partnership['owner-program']])
    @endif

    @if ($partnership['driver-program']['is_active'])
        @include('pages.partnership.sections.driver-program', ['data' => $partnership['driver-program']])
    @endif

    @if ($partnership['packages-benefits']['is_active'])
        @include('pages.partnership.sections.packages-benefits', ['data' => $partnership['packages-benefits']])
    @endif

    @if ($partnership['terms']['is_active'])
        @include('pages.partnership.sections.terms', ['data' => $partnership['terms']])
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/partnership/program-navigation.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/partnership/driver-journey.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/partnership/partnership-accordion.js') }}" defer></script>
@endpush
