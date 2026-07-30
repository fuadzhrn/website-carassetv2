@extends('layouts.app')

@section('title', 'Tentang dan Kontak CarAsset')

@section(
    'meta_description',
    'Kenali CarAsset, nilai perusahaan, informasi legalitas, pertanyaan umum, dan cara berkonsultasi mengenai program kendaraan produktif.'
)

@section('body-class', 'ca-page ca-page--about-contact')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/about-contact.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/about.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/vision-mission-values.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/legal-partners.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/faq.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/about-contact/contact-form.css') }}">
@endpush

@section('content')
    @include('pages.about-contact.sections.about')
    @include('pages.about-contact.sections.vision-mission-values')
    @include('pages.about-contact.sections.legal-partners')
    @include('pages.about-contact.sections.faq')
    @include('pages.about-contact.sections.contact-form')
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/about-contact/faq-accordion.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/about-contact/contact-form.js') }}" defer></script>
@endpush
