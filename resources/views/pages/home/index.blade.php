@extends('layouts.app')

@section('title', 'CarAsset — Mobil Bekerja, Aset Bertumbuh')

@section(
    'meta_description',
    'CarAsset membantu mitra memiliki dan mengelola kendaraan produktif melalui sistem operasional yang profesional dan transparan.'
)

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
    @include('pages.home.sections.hero')
    @include('pages.home.sections.income-opportunity')
    @include('pages.home.sections.process-summary')
    @include('pages.home.sections.partnership-choice')
    @include('pages.home.sections.consultation-cta')
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/home/home-reveal.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/home/process-journey.js') }}" defer></script>
@endpush
