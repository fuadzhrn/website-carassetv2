@props(['variant' => 'neutral'])

@php
    $allowed = ['active', 'inactive', 'draft', 'published', 'pending', 'neutral'];
    $variant = in_array($variant, $allowed, true) ? $variant : 'neutral';
@endphp

<span {{ $attributes->merge(['class' => 'ca-admin-badge ca-admin-badge--' . $variant]) }}>
    {{ $slot }}
</span>
