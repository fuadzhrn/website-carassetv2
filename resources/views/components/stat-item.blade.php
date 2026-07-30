@props([
    'value',
    'label',
])

<div {{ $attributes->merge(['class' => 'ca-stat-item']) }}>
    <span class="ca-stat-item__value ca-section-title">{{ $value }}</span>
    <span class="ca-stat-item__label ca-body-text">{{ $label }}</span>
</div>
