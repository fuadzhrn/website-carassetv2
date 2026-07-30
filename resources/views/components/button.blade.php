@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
])

@php
    $variantClass = 'ca-button ca-button--' . $variant . ' ca-button-text';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $variantClass]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $variantClass]) }}>
        {{ $slot }}
    </button>
@endif
