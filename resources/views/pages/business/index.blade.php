@extends('layouts.app')

@section('title', 'Bisnis CarAsset — Own, Operate, Grow')

@section(
    'meta_description',
    'Pelajari bagaimana CarAsset membantu mitra memiliki, mengoperasikan, dan mengembangkan aset kendaraan produktif melalui sistem yang profesional.'
)

@section('body-class', 'ca-page ca-page--business')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/business.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/opportunity.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/own.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/operate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/grow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/business/business-flow.css') }}">
@endpush

@section('content')
    @include('pages.business.sections.opportunity')
    @include('pages.business.sections.own')
    @include('pages.business.sections.operate')
    @include('pages.business.sections.grow')
    @include('pages.business.sections.business-flow')
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/business/business-reveal.js') }}" defer></script>
    <script src="{{ asset('assets/js/pages/business/monitoring-illustration.js') }}" defer></script>
@endpush
