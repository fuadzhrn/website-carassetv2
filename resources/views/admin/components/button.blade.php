@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'secondary',
    'size' => 'md',
    'icon' => null,
    'disabled' => false,
    'target' => null,
])

@php
    $allowedVariants = ['primary', 'secondary', 'outline', 'danger', 'ghost'];
    $allowedSizes = ['sm', 'md'];

    $variant = in_array($variant, $allowedVariants, true) ? $variant : 'secondary';
    $size = in_array($size, $allowedSizes, true) ? $size : 'md';

    $classes = 'ca-admin-btn ca-admin-btn--' . $variant . ' ca-admin-btn--' . $size;
@endphp

@if ($href && ! $disabled)
    <a
        href="{{ $href }}"
        @if ($target) target="{{ $target }}" rel="noopener noreferrer" @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if ($icon)
            <span class="ca-admin-btn__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        @disabled($disabled)
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if ($icon)
            <span class="ca-admin-btn__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>
        @endif
        {{ $slot }}
    </button>
@endif
