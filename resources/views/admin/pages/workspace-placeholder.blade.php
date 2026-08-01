@extends('admin.layouts.app')

@section('title', $title.' — Panel Admin CarAsset')
@section('page-title', $title)

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website', 'route' => route('admin.pages.index')],
        ['label' => $title],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-pages.css') }}">
@endpush

@section('content')
    <section class="ca-admin-section">
        <div class="ca-admin-workspace-header">
            <div>
                <p class="ca-admin-section__description">{{ $description }}</p>
            </div>
            <x-admin::button :href="route($publicRoute)" target="_blank" variant="outline" size="sm" icon="external-link">
                Lihat Halaman Publik
            </x-admin::button>
        </div>

        <div class="ca-admin-section-list">
            @foreach ($sections as $index => $sectionName)
                <div class="ca-admin-section-row">
                    <span class="ca-admin-section-row__number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <span class="ca-admin-section-row__name">{{ $sectionName }}</span>
                    <x-admin::status-badge variant="pending">Belum Terhubung</x-admin::status-badge>
                    <span class="ca-admin-section-row__action" title="Editor tersedia pada tahap berikutnya" aria-disabled="true">
                        Editor tersedia pada tahap berikutnya
                    </span>
                </div>
            @endforeach
        </div>
    </section>
@endsection
