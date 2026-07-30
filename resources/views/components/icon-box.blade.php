@props([
    'icon' => 'circle',
    'title',
])

<div {{ $attributes->merge(['class' => 'ca-icon-box']) }}>
    <span class="ca-icon-box__icon" data-lucide="{{ $icon }}" aria-hidden="true"></span>
    <h3 class="ca-icon-box__title ca-card-title">{{ $title }}</h3>
    <div class="ca-icon-box__description ca-body-text">
        {{ $slot }}
    </div>
</div>
