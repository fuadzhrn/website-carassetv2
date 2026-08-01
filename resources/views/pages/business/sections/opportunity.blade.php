{{-- SECTION 1 — Peluang Bisnis Kendaraan Produktif --}}
<section id="peluang-bisnis" class="ca-opportunity">
    <div class="ca-opportunity__hero" data-reveal>
        @if ($data['image']['url'])
            <img
                src="{{ $data['image']['url'] }}"
                alt="{{ $data['image']['alt'] }}"
                width="1920"
                height="900"
                fetchpriority="high"
                decoding="async"
                class="ca-opportunity__hero-image"
            >
        @endif
        <div class="ca-opportunity__hero-overlay" aria-hidden="true"></div>

        <div class="ca-container ca-opportunity__hero-content">
            @if ($data['eyebrow'])
                <span class="ca-opportunity__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif

            <h1 class="ca-opportunity__title ca-page-title">
                {{ $data['title'] }}
            </h1>

            <p class="ca-opportunity__description ca-body-lg">
                {{ $data['description'] }}
            </p>

            @if ($data['cta'])
                <a href="{{ $data['cta']['url'] }}" target="{{ $data['cta']['target'] }}" class="ca-opportunity__cta ca-nav-text">
                    {{ $data['cta']['label'] }}
                    <span class="ca-opportunity__cta-icon" data-lucide="arrow-down-right" aria-hidden="true"></span>
                </a>
            @endif
        </div>
    </div>

    <div class="ca-container ca-opportunity__diagram-section">
        <div class="ca-opportunity__diagram">
            <div class="ca-opportunity__diagram-track" aria-hidden="true"></div>

            <div class="ca-opportunity__diagram-step">
                <span class="ca-opportunity__diagram-icon" data-lucide="key-round" aria-hidden="true"></span>
                <span class="ca-opportunity__diagram-label ca-label">{{ $data['diagram']['step_1_label'] }}</span>
            </div>
            <div class="ca-opportunity__diagram-step">
                <span class="ca-opportunity__diagram-icon" data-lucide="settings" aria-hidden="true"></span>
                <span class="ca-opportunity__diagram-label ca-label">{{ $data['diagram']['step_2_label'] }}</span>
            </div>
            <div class="ca-opportunity__diagram-step ca-opportunity__diagram-step--accent">
                <span class="ca-opportunity__diagram-icon" data-lucide="file-bar-chart" aria-hidden="true"></span>
                <span class="ca-opportunity__diagram-label ca-label">{{ $data['diagram']['step_3_label'] }}</span>
            </div>
            <div class="ca-opportunity__diagram-step ca-opportunity__diagram-step--gold">
                <span class="ca-opportunity__diagram-icon" data-lucide="trending-up" aria-hidden="true"></span>
                <span class="ca-opportunity__diagram-label ca-label">{{ $data['diagram']['step_4_label'] }}</span>
            </div>
        </div>
    </div>
</section>
