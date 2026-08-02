@extends('admin.layouts.app')

@section('title', 'Konten Website — Panel Admin CarAsset')
@section('page-title', 'Konten Website')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Konten Website'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-pages.css') }}">
@endpush

@section('content')
    <section class="ca-admin-section">
        <p class="ca-admin-section__description">
            Kelola isi setiap halaman CarAsset melalui section yang terstruktur.
        </p>

        <x-admin::data-table caption="Daftar halaman website CarAsset yang dikelola">
            <x-slot:header>
                <tr>
                    <th scope="col">Nama Halaman</th>
                    <th scope="col">Route Publik</th>
                    <th scope="col">Jumlah Section</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="ca-admin-table__action-col">Aksi</th>
                </tr>
            </x-slot:header>

            @foreach ($pages as $key => $page)
                <tr>
                    <td>{{ $page['title'] }}</td>
                    <td><code>{{ route($page['route']) }}</code></td>
                    <td>5 section</td>
                    <td>
                        <x-admin::status-badge variant="active">Terhubung ke CMS</x-admin::status-badge>
                    </td>
                    <td class="ca-admin-table__action-col">
                        <div class="ca-admin-table__actions">
                            <x-admin::button :href="route('admin.pages.'.$key)" variant="ghost" size="sm" icon="arrow-right">
                                Buka Editor
                            </x-admin::button>
                            <x-admin::button :href="route($page['route'])" target="_blank" variant="outline" size="sm" icon="external-link">
                                Lihat Halaman Publik
                            </x-admin::button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-admin::data-table>
    </section>
@endsection
