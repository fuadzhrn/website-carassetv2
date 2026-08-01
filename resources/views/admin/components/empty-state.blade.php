@props([
    'icon' => 'inbox',
    'title' => 'Belum Ada Data',
    'description' => null,
])

<div class="ca-admin-empty-state">
    <span class="ca-admin-empty-state__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>
    <p class="ca-admin-empty-state__title">{{ $title }}</p>
    @if ($description)
        <p class="ca-admin-empty-state__description">{{ $description }}</p>
    @endif
    @isset($action)
        <div class="ca-admin-empty-state__action">
            {{ $action }}
        </div>
    @endisset
</div>
