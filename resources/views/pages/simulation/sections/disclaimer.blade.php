{{-- SECTION 5 — Disclaimer Proyeksi (Transparent Decision Panel) --}}
<section id="disclaimer-simulasi" class="ca-simulation-disclaimer">
    <div class="ca-container ca-simulation-disclaimer__inner">
        <div class="ca-simulation-disclaimer__panel">
            <span class="ca-simulation-disclaimer__icon" data-lucide="shield-alert" aria-hidden="true"></span>

            @if ($data['eyebrow'])
                <span class="ca-simulation-disclaimer__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif

            <h2 class="ca-simulation-disclaimer__title ca-section-title">
                {{ $data['title'] }}
            </h2>

            <div class="ca-simulation-disclaimer__body">
                @foreach ($data['description_paragraphs'] as $paragraph)
                    <p class="ca-body">{{ $paragraph }}</p>
                @endforeach
            </div>

            @if ($data['points'])
                <ul class="ca-simulation-disclaimer__points ca-list-reset">
                    @foreach ($data['points'] as $point)
                        <li>{{ $point['text'] }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="ca-simulation-disclaimer__cta">
            <h3 class="ca-simulation-disclaimer__cta-title ca-card-title">
                {{ $data['cta_title'] }}
            </h3>
            <p class="ca-body">
                {{ $data['cta_description'] }}
            </p>

            <div class="ca-simulation-disclaimer__actions ca-cluster">
                @if ($data['primary_cta'])
                    <x-button href="{{ $data['primary_cta']['url'] }}" target="{{ $data['primary_cta']['target'] }}" variant="primary" size="lg">
                        {{ $data['primary_cta']['label'] }}
                    </x-button>
                @endif
                @if ($data['secondary_cta'])
                    <x-button href="{{ $data['secondary_cta']['url'] }}" target="{{ $data['secondary_cta']['target'] }}" variant="outline" size="lg">
                        {{ $data['secondary_cta']['label'] }}
                    </x-button>
                @endif
            </div>

            <p class="ca-simulation-disclaimer__microcopy ca-body-sm">
                {{ $data['microcopy'] }}
            </p>
        </div>
    </div>
</section>
