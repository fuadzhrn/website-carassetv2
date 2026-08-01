@php
    $flashTypes = [
        'success' => ['icon' => 'circle-check', 'role' => 'status'],
        'info' => ['icon' => 'info', 'role' => 'status'],
        'warning' => ['icon' => 'triangle-alert', 'role' => 'alert'],
        'error' => ['icon' => 'circle-alert', 'role' => 'alert'],
        // 'status' — dipakai halaman login/logout (layout terpisah), disertakan
        // di sini juga untuk jaga-jaga bila suatu saat direct ke area admin.
        'status' => ['icon' => 'info', 'role' => 'status'],
    ];
@endphp

@foreach ($flashTypes as $key => $meta)
    @if (session($key))
        <div
            class="ca-admin-flash ca-admin-flash--{{ $key === 'status' ? 'info' : $key }}"
            role="{{ $meta['role'] }}"
            data-flash-message
        >
            <span class="ca-admin-flash__icon" data-lucide="{{ $meta['icon'] }}" aria-hidden="true"></span>
            <p class="ca-admin-flash__text">{{ session($key) }}</p>
            <button type="button" class="ca-admin-flash__close" data-flash-close aria-label="Tutup notifikasi">
                <span data-lucide="x" aria-hidden="true"></span>
            </button>
        </div>
    @endif
@endforeach
