@extends('layouts.app')

{{-- Title/meta description now come from PageSeoService (see partials.seo-meta) --}}
@section('body-class', 'ca-page ca-page--home')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home/home.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home/income-opportunity.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home/process-summary.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home/partnership-choice.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/home/consultation-cta.css') }}">
@endpush

@section('content')
    @if ($home['hero']['is_active'])
        @include('pages.home.sections.hero', ['data' => $home['hero']])
    @endif

    @if ($home['income-opportunity']['is_active'])
        @include('pages.home.sections.income-opportunity', ['data' => $home['income-opportunity']])
    @endif

    @if ($home['process-summary']['is_active'])
        @include('pages.home.sections.process-summary', ['data' => $home['process-summary']])
    @endif

    @if ($home['partnership-choice']['is_active'])
        @include('pages.home.sections.partnership-choice', ['data' => $home['partnership-choice']])
    @endif

    @if ($home['consultation-cta']['is_active'])
        @include('pages.home.sections.consultation-cta', ['data' => $home['consultation-cta']])
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/home/hero-intro.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/home/home-reveal.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/home/process-journey.js') }}" defer></script>
@endpush
