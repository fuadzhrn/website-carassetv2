{{-- SECTION 1 — Hero & Value Proposition (Cinematic Center-Stage) --}}
<section class="ca-hero ca-hero--center-stage" aria-labelledby="ca-hero-heading" data-hero-intro>
    <div class="ca-hero__glow" aria-hidden="true"></div>

    <div class="ca-container ca-hero__container">
        <div class="ca-hero__content" data-hero-part="content">
            @if ($data['eyebrow'])
                <span class="ca-hero__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif

            <h1 id="ca-hero-heading" class="ca-hero__title ca-display">
                {{ $data['title_line_1'] }}<br>
                Aset <span class="ca-hero__title-accent">{{ $data['title_line_2'] }}</span>
            </h1>

            @if ($data['subtitle'])
                <p class="ca-hero__subheadline">{{ $data['subtitle'] }}</p>
            @endif

            <p class="ca-hero__description ca-body-lg">
                {{ $data['description'] }}
            </p>

            @if ($data['primary_cta'] || $data['secondary_cta'])
                <div class="ca-hero__actions ca-cluster">
                    @if ($data['primary_cta'])
                        <x-button
                            href="{{ $data['primary_cta']['url'] }}"
                            target="{{ $data['primary_cta']['target'] }}"
                            variant="primary"
                            size="lg"
                        >
                            {{ $data['primary_cta']['label'] }}
                        </x-button>
                    @endif
                    @if ($data['secondary_cta'])
                        <x-button
                            href="{{ $data['secondary_cta']['url'] }}"
                            target="{{ $data['secondary_cta']['target'] }}"
                            variant="outline"
                            size="lg"
                        >
                            {{ $data['secondary_cta']['label'] }}
                        </x-button>
                    @endif
                </div>
            @endif
        </div>

        <div class="ca-hero__stage" data-hero-part="stage">
            <svg class="ca-hero__route" viewBox="0 0 1000 260" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                <path class="ca-hero__route-path" d="M 20 220 C 260 220, 300 60, 500 130 C 700 200, 740 40, 980 30" />
                <circle class="ca-hero__route-dot ca-hero__route-dot--green" cx="345" cy="112" r="6" />
                <circle class="ca-hero__route-dot ca-hero__route-dot--gold" cx="742" cy="45" r="6" />
            </svg>

            <div class="ca-hero__mark" aria-hidden="true">
                <span class="ca-hero__mark-ring ca-hero__mark-ring--outer"></span>
                <span class="ca-hero__mark-ring ca-hero__mark-ring--inner"></span>
                <span class="ca-hero__mark-core">
                    <span class="ca-hero__mark-icon" data-lucide="car-front" aria-hidden="true"></span>
                </span>
            </div>
        </div>

        @php
            $heroStatusIcons = [0 => 'badge-check', 1 => 'settings', 2 => 'activity'];
        @endphp
        @if ($data['status_items'])
            <div class="ca-hero-status" data-hero-part="status">
                @foreach ($data['status_items'] as $slot => $item)
                    @if (! $loop->first)
                        <span class="ca-hero-status__separator" aria-hidden="true"></span>
                    @endif
                    <div class="ca-hero-status__item">
                        <span class="ca-hero-status__icon" data-lucide="{{ $heroStatusIcons[$slot] ?? 'badge-check' }}" aria-hidden="true"></span>
                        <span class="ca-hero-status__label ca-label">{{ $item['label'] }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
