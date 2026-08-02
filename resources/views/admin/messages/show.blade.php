@extends('admin.layouts.app')

@section('title', 'Detail Pesan — Panel Admin CarAsset')
@section('page-title', 'Detail Pesan')

@section('breadcrumbs')
    <x-admin::breadcrumb :items="[
        ['label' => 'Dashboard', 'route' => route('admin.dashboard')],
        ['label' => 'Pesan Masuk', 'route' => route('admin.messages.index')],
        ['label' => $message->name],
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

    $whatsappDigits = preg_replace('/\D+/', '', $message->whatsapp);
    if (str_starts_with($whatsappDigits, '0')) {
        $whatsappDigits = '62'.substr($whatsappDigits, 1);
    }
    $whatsappManualUrl = strlen($whatsappDigits) >= 8 ? 'https://wa.me/'.$whatsappDigits : null;
@endphp

@section('content')
    <div class="ca-admin-message-detail">
        <div class="ca-admin-message-detail__header">
            <div>
                <h2 class="ca-admin-message-detail__name">{{ $message->name }}</h2>
                <p class="ca-admin-message-detail__meta">
                    Dikirim {{ $message->created_at->translatedFormat('d F Y, H:i') }} ({{ $message->created_at->diffForHumans() }})
                </p>
            </div>
            <x-admin::status-badge :variant="$message->status">{{ $statusLabels[$message->status] ?? ucfirst($message->status) }}</x-admin::status-badge>
        </div>

        <div class="ca-admin-message-detail__rows">
            <div class="ca-admin-message-detail__row">
                <span class="ca-admin-message-detail__label">Nomor WhatsApp</span>
                <span class="ca-admin-message-detail__value">
                    {{ $message->whatsapp }}
                    @if ($whatsappManualUrl)
                        <a href="{{ $whatsappManualUrl }}" target="_blank" rel="noopener noreferrer" class="ca-admin-message-detail__manual-link">
                            <span data-lucide="external-link" aria-hidden="true"></span>
                            Buka WhatsApp
                        </a>
                    @endif
                </span>
            </div>

            <div class="ca-admin-message-detail__row">
                <span class="ca-admin-message-detail__label">Email</span>
                <span class="ca-admin-message-detail__value">
                    @if ($message->email)
                        {{ $message->email }}
                        <a href="mailto:{{ $message->email }}" class="ca-admin-message-detail__manual-link">
                            <span data-lucide="mail" aria-hidden="true"></span>
                            Kirim Email Manual
                        </a>
                    @else
                        <span class="ca-admin-message-detail__empty">Tidak diisi</span>
                    @endif
                </span>
            </div>

            <div class="ca-admin-message-detail__row">
                <span class="ca-admin-message-detail__label">Program</span>
                <span class="ca-admin-message-detail__value">{{ $message->program }}</span>
            </div>

            <div class="ca-admin-message-detail__row">
                <span class="ca-admin-message-detail__label">Persetujuan</span>
                <span class="ca-admin-message-detail__value">
                    {{ $message->consent ? 'Disetujui' : 'Tidak disetujui' }}
                    @if ($message->consented_at)
                        pada {{ $message->consented_at->translatedFormat('d F Y, H:i') }}
                    @endif
                </span>
            </div>
        </div>

        <div class="ca-admin-message-detail__panel">
            <h3 class="ca-admin-message-detail__panel-title">Pesan</h3>
            <p class="ca-admin-message-detail__message">{{ $message->message }}</p>
        </div>

        <div class="ca-admin-message-detail__timeline">
            <h3 class="ca-admin-message-detail__panel-title">Riwayat Status</h3>
            <ul class="ca-admin-message-timeline">
                <li class="ca-admin-message-timeline__item is-done">
                    <span class="ca-admin-message-timeline__label">Masuk</span>
                    <span class="ca-admin-message-timeline__time">{{ $message->created_at->translatedFormat('d F Y, H:i') }}</span>
                </li>
                <li class="ca-admin-message-timeline__item {{ $message->read_at ? 'is-done' : '' }}">
                    <span class="ca-admin-message-timeline__label">Dibaca</span>
                    <span class="ca-admin-message-timeline__time">{{ $message->read_at?->translatedFormat('d F Y, H:i') ?? '—' }}</span>
                </li>
                <li class="ca-admin-message-timeline__item {{ $message->completed_at ? 'is-done' : '' }}">
                    <span class="ca-admin-message-timeline__label">Selesai</span>
                    <span class="ca-admin-message-timeline__time">{{ $message->completed_at?->translatedFormat('d F Y, H:i') ?? '—' }}</span>
                </li>
                <li class="ca-admin-message-timeline__item {{ $message->archived_at ? 'is-done' : '' }}">
                    <span class="ca-admin-message-timeline__label">Diarsipkan</span>
                    <span class="ca-admin-message-timeline__time">{{ $message->archived_at?->translatedFormat('d F Y, H:i') ?? '—' }}</span>
                </li>
            </ul>

            @if ($message->handledBy)
                <p class="ca-admin-message-detail__handled-by">
                    Terakhir diubah oleh {{ $message->handledBy->name }}
                </p>
            @endif

            @if (config('contact-form.privacy.store_ip_address') && $message->ip_address)
                <p class="ca-admin-message-detail__handled-by">IP: {{ $message->ip_address }}</p>
            @endif

            @if (config('contact-form.privacy.store_user_agent') && $message->user_agent)
                <p class="ca-admin-message-detail__handled-by">User Agent: {{ $message->user_agent }}</p>
            @endif
        </div>

        <div class="ca-admin-message-detail__actions">
            @if ($message->status === 'new')
                <form method="POST" action="{{ route('admin.messages.status.update', $message) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="read">
                    <x-admin::button type="submit" variant="outline" size="sm">Tandai Dibaca</x-admin::button>
                </form>
                <form method="POST" action="{{ route('admin.messages.status.update', $message) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="completed">
                    <x-admin::button type="submit" variant="primary" size="sm">Tandai Selesai</x-admin::button>
                </form>
                <form method="POST" action="{{ route('admin.messages.status.update', $message) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="archived">
                    <x-admin::button type="submit" variant="ghost" size="sm">Arsipkan</x-admin::button>
                </form>
            @elseif ($message->status === 'read')
                <form method="POST" action="{{ route('admin.messages.status.update', $message) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="completed">
                    <x-admin::button type="submit" variant="primary" size="sm">Tandai Selesai</x-admin::button>
                </form>
                <form method="POST" action="{{ route('admin.messages.status.update', $message) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="archived">
                    <x-admin::button type="submit" variant="ghost" size="sm">Arsipkan</x-admin::button>
                </form>
            @elseif ($message->status === 'completed')
                <form method="POST" action="{{ route('admin.messages.status.update', $message) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="read">
                    <x-admin::button type="submit" variant="outline" size="sm">Buka Kembali</x-admin::button>
                </form>
                <form method="POST" action="{{ route('admin.messages.status.update', $message) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="archived">
                    <x-admin::button type="submit" variant="ghost" size="sm">Arsipkan</x-admin::button>
                </form>
            @elseif ($message->status === 'archived')
                <form method="POST" action="{{ route('admin.messages.status.update', $message) }}">
                    @csrf @method('PATCH')
                    <input type="hidden" name="status" value="read">
                    <x-admin::button type="submit" variant="outline" size="sm">Kembalikan ke Dibaca</x-admin::button>
                </form>

                <x-admin::confirm-dialog
                    id="delete-message-{{ $message->id }}"
                    title="Hapus Pesan Permanen"
                    message="Pesan yang dihapus secara permanen tidak dapat dikembalikan."
                    :form-action="route('admin.messages.destroy', $message)"
                    form-method="DELETE"
                    confirm-label="Hapus Permanen"
                    trigger-label="Hapus Permanen"
                />
            @endif
        </div>

        <div class="ca-admin-message-detail__back">
            <x-admin::button :href="route('admin.messages.index')" variant="ghost" size="sm" icon="arrow-left">
                Kembali ke Daftar
            </x-admin::button>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/admin-messages.js') }}" defer></script>
@endpush
