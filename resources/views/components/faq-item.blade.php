@props([
    'question',
])

<details {{ $attributes->merge(['class' => 'ca-faq-item']) }}>
    <summary class="ca-faq-item__question ca-card-title">{{ $question }}</summary>
    <div class="ca-faq-item__answer ca-faq-text">
        {{ $slot }}
    </div>
</details>
