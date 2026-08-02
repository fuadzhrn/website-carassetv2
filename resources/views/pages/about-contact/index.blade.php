@extends('layouts.app')

{{-- Title/meta description now come from PageSeoService (see partials.seo-meta) --}}
@section('body-class', 'ca-page ca-page--about-contact')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/about-contact.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/about.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/vision-mission-values.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/legal-partners.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/faq.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/contact-form.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive/about-contact-mobile.css') }}">
@endpush

@section('content')
    @if ($aboutContact['about']['is_active'])
        @include('pages.about-contact.sections.about', ['data' => $aboutContact['about']])
    @endif

    @if ($aboutContact['vision-mission-values']['is_active'])
        @include('pages.about-contact.sections.vision-mission-values', ['data' => $aboutContact['vision-mission-values']])
    @endif

    @if ($aboutContact['legal-partners']['is_active'])
        @include('pages.about-contact.sections.legal-partners', ['data' => $aboutContact['legal-partners']])
    @endif

    @if ($aboutContact['faq']['is_active'])
        @include('pages.about-contact.sections.faq', ['data' => $aboutContact['faq']])
    @endif

    @if ($aboutContact['contact-form']['is_active'])
        @include('pages.about-contact.sections.contact-form', ['data' => $aboutContact['contact-form']])
    @endif
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/about-contact/faq-accordion.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/about-contact/contact-form.js') }}" defer></script>
@endpush
