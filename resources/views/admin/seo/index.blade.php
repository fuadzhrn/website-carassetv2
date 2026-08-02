@extends('admin.layouts.app')

@section('title', 'SEO Per Halaman — Panel Admin CarAsset')
@section('page-title', 'SEO Per Halaman')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'SEO Per Halaman'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-seo.css') }}">
@endpush

@section('content')
    <section class="ca-admin-section">
        <p class="ca-admin-section__description">
            Kelola metadata dasar lima halaman utama CarAsset tanpa mengubah URL, route, sitemap, atau struktur heading.
        </p>

        <x-admin::data-table caption="Status SEO lima halaman utama CarAsset">
            <x-slot:header>
                <tr>
                    <th scope="col">Halaman</th>
                    <th scope="col">URL Publik</th>
                    <th scope="col">Status SEO</th>
                    <th scope="col">Robots</th>
                    <th scope="col">Canonical</th>
                    <th scope="col">Waktu Publish</th>
                    <th scope="col" class="ca-admin-table__action-col">Aksi</th>
                </tr>
            </x-slot:header>

            @foreach ($rows as $row)
                <tr>
                    <td>{{ $row['name'] }}</td>
                    <td><code>{{ $row['public_url'] }}</code></td>
                    <td>
                        @if ($row['has_draft'])
                            <x-admin::status-badge variant="draft">Draft SEO Belum Dipublikasikan</x-admin::status-badge>
                        @else
                            <x-admin::status-badge variant="published">SEO Published</x-admin::status-badge>
                        @endif
                    </td>
                    <td>
                        {{ $row['robots'] === 'index,follow' ? 'Izinkan Pengindeksan' : 'Jangan Indeks Halaman' }}
                    </td>
                    <td>
                        <span class="ca-admin-seo-canonical-value">{{ $row['canonical'] }}</span>
                        <span class="ca-admin-seo-canonical-tag">{{ $row['canonical_source'] === 'custom' ? 'Custom' : 'Otomatis dari Route' }}</span>
                    </td>
                    <td>
                        @if ($row['published_at'])
                            {{ $row['published_at']->translatedFormat('d F Y, H:i') }}
                            @if ($row['published_by'])
                                <br><span class="ca-admin-table__muted">oleh {{ $row['published_by']->name }}</span>
                            @endif
                        @else
                            <span class="ca-admin-table__muted">Belum tercatat</span>
                        @endif
                    </td>
                    <td class="ca-admin-table__action-col">
                        <div class="ca-admin-table__actions">
                            <x-admin::button :href="route('admin.seo.edit', $row['page']->slug)" variant="ghost" size="sm" icon="arrow-right">
                                Edit SEO
                            </x-admin::button>
                            <x-admin::button :href="$row['public_url']" target="_blank" variant="outline" size="sm" icon="external-link">
                                Lihat Halaman Publik
                            </x-admin::button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin::data-table>
    </section>
@endsection
