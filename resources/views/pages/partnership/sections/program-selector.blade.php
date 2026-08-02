{{-- SECTION 1 — Pilih Jalur Kemitraan (Branched Pathway) --}}
<section id="pilih-program" class="ca-program-selector" aria-labelledby="ca-partnership-heading">
    <div class="ca-container ca-program-selector__intro">
        @if ($data['eyebrow'])
            <span class="ca-program-selector__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
        @endif

        <h1 id="ca-partnership-heading" class="ca-program-selector__title ca-page-title">
            {!! nl2br(e($data['title'])) !!}
        </h1>

        <p class="ca-program-selector__description ca-body-lg">
            {{ $data['description'] }}
        </p>
    </div>

    <div class="ca-container ca-program-selector__branch">
        <svg class="ca-program-selector__branch-line" viewBox="0 0 800 140" preserveAspectRatio="none" aria-hidden="true" focusable="false">
            <path class="ca-program-selector__branch-path" d="M 400 0 L 400 35 C 400 70, 260 60, 165 105" />
            <path class="ca-program-selector__branch-path" d="M 400 0 L 400 35 C 400 70, 540 60, 635 105" />
            <circle class="ca-program-selector__branch-dot ca-program-selector__branch-dot--navy" cx="165" cy="108" r="6" />
            <circle class="ca-program-selector__branch-dot ca-program-selector__branch-dot--green" cx="635" cy="108" r="6" />
        </svg>

        <div class="ca-program-selector__paths">
            @if ($data['owner']['is_active'])
                <div class="ca-program-selector__path ca-program-selector__path--owner">
                    <span class="ca-program-selector__path-icon" data-lucide="key-round" aria-hidden="true"></span>
                    <h3 class="ca-program-selector__path-title ca-card-title">{{ $data['owner']['title'] }}</h3>
                    <p class="ca-program-selector__path-description ca-body-sm">
                        {{ $data['owner']['description'] }}
                    </p>
                    <a href="#mitra-owner" class="ca-program-selector__path-cta ca-nav-text" data-program-link="mitra-owner">
                        {{ $data['owner']['cta_label'] }}
                    </a>
                </div>
            @endif

            @if ($data['driver']['is_active'])
                <div class="ca-program-selector__path ca-program-selector__path--driver">
                    <span class="ca-program-selector__path-icon" data-lucide="route" aria-hidden="true"></span>
                    <h3 class="ca-program-selector__path-title ca-card-title">{{ $data['driver']['title'] }}</h3>
                    <p class="ca-program-selector__path-description ca-body-sm">
                        {{ $data['driver']['description'] }}
                    </p>
                    <a href="#mitra-driver" class="ca-program-selector__path-cta ca-nav-text" data-program-link="mitra-driver">
                        {{ $data['driver']['cta_label'] }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

<nav class="ca-program-nav" aria-label="Navigasi program kemitraan" data-program-nav>
    <div class="ca-container ca-program-nav__inner">
        @if ($data['owner']['is_active'])
            <a href="#mitra-owner" class="ca-program-nav__link" data-program-nav-link="mitra-owner">
                {{ $data['owner']['label'] }}
            </a>
        @endif
        @if ($data['driver']['is_active'])
            <a href="#mitra-driver" class="ca-program-nav__link" data-program-nav-link="mitra-driver">
                {{ $data['driver']['label'] }}
            </a>
        @endif
    </div>
</nav>
