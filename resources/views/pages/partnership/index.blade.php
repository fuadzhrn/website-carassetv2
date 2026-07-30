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
    @include('pages.partnership.sections.program-selector')
    @include('pages.partnership.sections.owner-program')
    @include('pages.partnership.sections.driver-program')
    @include('pages.partnership.sections.packages-benefits')
    @include('pages.partnership.sections.terms')
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/partnership/program-navigation.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/partnership/driver-journey.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/partnership/partnership-accordion.js') }}" defer></script>
@endpush
