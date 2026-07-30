@props([
    'eyebrow' => null,
    'title',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'ca-section-heading']) }}>
    @if ($eyebrow)
        <span class="ca-section-heading__eyebrow ca-nav-text">{{ $eyebrow }}</span>
    @endif

    <h2 class="ca-section-heading__title ca-section-title">{{ $title }}</h2>

    @if ($subtitle)
        <p class="ca-section-heading__subtitle ca-body-text">{{ $subtitle }}</p>
    @endif
</div>
