@props([
    'icon' => 'circle',
    'title',
    'description' => null,
    'variant' => 'light',
    'size' => 'md',
])

@php
    $allowedVariants = ['light', 'navy', 'green', 'gold-soft'];
    $allowedSizes = ['sm', 'md', 'lg'];

    $variant = in_array($variant, $allowedVariants, true) ? $variant : 'light';
    $size = in_array($size, $allowedSizes, true) ? $size : 'md';

    $classes = 'ca-icon-box ca-icon-box--' . $variant . ' ca-icon-box--icon-' . $size;
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <span class="ca-icon-box__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>

    <div class="ca-icon-box__content">
        <h3 class="ca-icon-box__title ca-card-title">{{ $title }}</h3>

        @if ($description)
            <p class="ca-icon-box__description ca-body-sm">{{ $description }}</p>
        @endif
    </div>
</div>
