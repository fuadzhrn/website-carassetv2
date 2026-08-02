@extends('admin.layouts.app')

@section('title', 'Pesan Masuk — Panel Admin CarAsset')
@section('page-title', 'Pesan Masuk')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Pesan Masuk'],
    ]" />
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin-messages.css') }}">
@endpush

@php
    $statusLabels = [
        'new' => 'Baru',
        'read' => 'Dibaca',
        'completed' => 'Selesai',
        'archived' => 'Diarsipkan',
    ];
@endphp

@section('content')
    <p class="ca-admin-section__description">
        Tinjau dan kelola permintaan konsultasi yang dikirim melalui website CarAsset.
    </p>

    <form method="GET" action="{{ route('admin.messages.index') }}" class="ca-admin-messages-toolbar" role="search">
        <div class="ca-admin-field">
            <label for="messages-search" class="ca-admin-field__label">Cari Pesan</label>
            <input
                type="search"
                id="messages-search"
                name="search"
                class="ca-admin-field__control"
                value="{{ $search }}"
                maxlength="100"
                placeholder="Nama, program, email, atau WhatsApp"
            >
        </div>

        <div class="ca-admin-field">
            <label for="messages-status" class="ca-admin-field__label">Status</label>
            <select id="messages-status" name="status" class="ca-admin-field__control">
                <option value="all" @selected($status === 'all')>Semua Status</option>
                @foreach ($statusLabels as $key => $label)
                    <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <x-admin::button type="submit" variant="primary" size="sm" icon="search">
            Terapkan
        </x-admin::button>
    </form>

    <p class="ca-admin-messages-count">
        Menampilkan {{ $messages->count() }} dari {{ $messages->total() }} pesan.
    </p>

    <x-admin::data-table
        caption="Daftar pesan konsultasi yang dikirim melalui website CarAsset"
        :empty="$messages->total() === 0"
        empty-icon="inbox"
        :empty-title="$search !== '' || $status !== 'all' ? 'Pesan Tidak Ditemukan' : 'Belum Ada Pesan Masuk'"
        :empty-description="$search !== '' || $status !== 'all'
            ? 'Tidak ada pesan yang sesuai dengan pencarian atau filter yang dipilih.'
            : 'Permintaan konsultasi yang dikirim melalui website akan muncul di sini.'"
    >
        <x-slot:header>
            <tr>
                <th scope="col">Pengirim</th>
                <th scope="col">Kontak</th>
                <th scope="col">Program</th>
                <th scope="col">Status</th>
                <th scope="col">Waktu Masuk</th>
                <th scope="col" class="ca-admin-table__action-col">Aksi</th>
            </tr>
        </x-slot:header>

        @foreach ($messages as $message)
            <tr>
                <td>{{ $message->name }}</td>
                <td>
                    <span class="ca-admin-messages-contact">{{ $message->whatsapp }}</span>
                    @if ($message->email)
                        <span class="ca-admin-messages-contact ca-admin-messages-contact--secondary">{{ $message->email }}</span>
                    @endif
                </td>
                <td>{{ $message->program }}</td>
                <td>
                    <x-admin::status-badge :variant="$message->status">{{ $statusLabels[$message->status] ?? ucfirst($message->status) }}</x-admin::status-badge>
                </td>
                <td>
                    <span class="ca-admin-messages-time">{{ $message->created_at->translatedFormat('d F Y, H:i') }}</span>
                    <span class="ca-admin-messages-time ca-admin-messages-time--relative">{{ $message->created_at->diffForHumans() }}</span>
                </td>
                <td class="ca-admin-table__action-col">
                    <x-admin::button :href="route('admin.messages.show', $message)" variant="ghost" size="sm" icon="arrow-right">
                        Lihat Detail
                    </x-admin::button>
                </td>
            </tr>
        @endforeach

        <x-slot:pagination>
            {{ $messages->links() }}
        </x-slot:pagination>
    </x-admin::data-table>
@endsection
