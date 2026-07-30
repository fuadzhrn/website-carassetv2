@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'target' => null,
])

@php
    $allowedVariants = ['primary', 'secondary', 'outline', 'ghost', 'gold'];
    $allowedSizes = ['sm', 'md', 'lg'];

    $variant = in_array($variant, $allowedVariants, true) ? $variant : 'primary';
    $size = in_array($size, $allowedSizes, true) ? $size : 'md';

    $classes = 'ca-btn ca-btn--' . $variant . ' ca-btn--' . $size . ' ca-button-text';
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        @if ($target) target="{{ $target }}" rel="noopener" @endif
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if ($icon && $iconPosition === 'left')
            <span class="ca-btn__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>
        @endif

        <span class="ca-btn__label">{{ $slot }}</span>

        @if ($icon && $iconPosition === 'right')
            <span class="ca-btn__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>
        @endif
    </a>
@else
    <button
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
    >
        @if ($icon && $iconPosition === 'left')
            <span class="ca-btn__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>
        @endif

        <span class="ca-btn__label">{{ $slot }}</span>

        @if ($icon && $iconPosition === 'right')
            <span class="ca-btn__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>
        @endif
    </button>
@endif
