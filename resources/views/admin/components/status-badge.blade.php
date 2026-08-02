@props(['variant' => 'neutral'])

@php
    $allowed = ['active', 'inactive', 'draft', 'published', 'pending', 'neutral', 'new', 'read', 'completed', 'archived'];
    $variant = in_array($variant, $allowed, true) ? $variant : 'neutral';
@endphp

<span {{ $attributes->merge(['class' => 'ca-admin-badge ca-admin-badge--' . $variant]) }}>
    {{ $slot }}
</span>
