@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'align' => 'left',
    'theme' => 'light',
    'tag' => 'h2',
    'maxWidth' => null,
])

@php
    $allowedTags = ['h1', 'h2', 'h3'];
    $tag = in_array($tag, $allowedTags, true) ? $tag : 'h2';

    $modifiers = [];
    if ($align === 'center') {
        $modifiers[] = 'ca-section-heading--center';
    }
    if ($theme === 'dark') {
        $modifiers[] = 'ca-section-heading--dark';
    }

    $classes = trim('ca-section-heading ' . implode(' ', $modifiers));
@endphp

<div
    {{ $attributes->merge(['class' => $classes]) }}
    @if ($maxWidth) style="max-width: {{ $maxWidth }};" @endif
>
    @if ($eyebrow)
        <span class="ca-section-heading__eyebrow ca-eyebrow">{{ $eyebrow }}</span>
    @endif

    <{{ $tag }} class="ca-section-heading__title ca-section-title">{{ $title }}</{{ $tag }}>

    @if ($description)
        <p class="ca-section-heading__description ca-body">{{ $description }}</p>
    @endif
</div>
