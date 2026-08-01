@extends('admin.layouts.app')

@section('title', $title.' — Panel Admin CarAsset')
@section('page-title', $title)

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => $title],
    ]" />
@endsection

@section('content')
    <section class="ca-admin-section">
        <p class="ca-admin-section__description">{{ $description }}</p>

        <x-admin::empty-state
            icon="hammer"
            title="Modul Belum Tersedia"
            :description="$status"
        />
    </section>
@endsection
