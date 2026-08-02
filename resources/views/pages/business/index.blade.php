@extends('layouts.app')

{{-- Title/meta description now come from PageSeoService (see partials.seo-meta) --}}
@section('body-class', 'ca-page ca-page--business')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/business.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/opportunity.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/own.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/operate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/grow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/business-flow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive/business-mobile.css') }}">
@endpush

@section('content')
    @if ($business['opportunity']['is_active'])
        @include('pages.business.sections.opportunity', ['data' => $business['opportunity']])
    @endif

    @if ($business['own']['is_active'])
        @include('pages.business.sections.own', ['data' => $business['own']])
    @endif

    @if ($business['operate']['is_active'])
        @include('pages.business.sections.operate', ['data' => $business['operate']])
    @endif

    @if ($business['grow']['is_active'])
        @include('pages.business.sections.grow', ['data' => $business['grow']])
    @endif

    @if ($business['business-flow']['is_active'])
        @include('pages.business.sections.business-flow', ['data' => $business['business-flow']])
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/business/business-reveal.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/business/monitoring-illustration.js') }}" defer></script>
@endpush
