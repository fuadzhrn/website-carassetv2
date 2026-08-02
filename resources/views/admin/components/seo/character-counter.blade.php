{{--
    Length helper for one SEO field. Renders a server-computed initial
    status so it works with JavaScript disabled; admin-seo.js re-computes
    this live as the admin types via the data-seo-counter attributes.
    This is guidance only — the real length limit is still enforced by
    UpdatePageSeoRequest server-side.
--}}
@props([
    'inputId',
    'value' => '',
    'recommendedMin',
    'recommendedMax',
    'maxLength',
])

@php
    $length = mb_strlen((string) $value);

    $status = match (true) {
        $length === 0 => null,
        $length < $recommendedMin => ['label' => 'Kurang Pendek', 'class' => 'is-short'],
        $length <= $recommendedMax => ['label' => 'Rekomendasi', 'class' => 'is-good'],
        $length <= $maxLength => ['label' => 'Panjang', 'class' => 'is-long'],
        default => ['label' => 'Terlalu Panjang', 'class' => 'is-over'],
    };
@endphp

<p
    class="ca-admin-seo-counter {{ $status['class'] ?? '' }}"
    data-seo-counter
    data-counter-for="{{ $inputId }}"
    data-recommended-min="{{ $recommendedMin }}"
    data-recommended-max="{{ $recommendedMax }}"
    data-max-length="{{ $maxLength }}"
>
    <span data-seo-counter-length>{{ $length }}</span> / {{ $maxLength }} karakter
    (rekomendasi {{ $recommendedMin }}–{{ $recommendedMax }})
    @if ($status)
        — <span data-seo-counter-label>{{ $status['label'] }}</span>
    @else
        — <span data-seo-counter-label></span>
    @endif
</p>
