{{-- SECTION 5 — Persyaratan & Ketentuan (Transparent Requirements) --}}
<section id="persyaratan" class="ca-terms">
    <div class="ca-container ca-terms__inner">
        <x-section-heading
            align="center"
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        @php
            $checkpointIcons = [0 => 'files', 1 => 'clipboard-check', 2 => 'wallet-cards', 3 => 'route'];
            $checkpointCount = count($data['checkpoints']);
            $checkpointIndex = 0;
        @endphp
        <div class="ca-terms__checkpoint">
            @foreach ($data['checkpoints'] as $slot => $checkpoint)
                <div class="ca-terms__checkpoint-item">
                    <span class="ca-terms__checkpoint-icon" data-lucide="{{ $checkpointIcons[$slot] ?? 'files' }}" aria-hidden="true"></span>
                    <span class="ca-nav-text">{{ $checkpoint['title'] }}</span>
                </div>
                @if (++$checkpointIndex < $checkpointCount)
                    <span class="ca-terms__checkpoint-arrow" data-lucide="chevron-right" aria-hidden="true"></span>
                @endif
            @endforeach
        </div>

        <div class="ca-accordion" data-accordion>
            @if ($data['verification']['is_active'])
                <div class="ca-accordion__item">
                    <h3 class="ca-accordion__heading">
                        <button
                            type="button"
                            class="ca-accordion__trigger"
                            aria-expanded="true"
                            aria-controls="ca-accordion-panel-1"
                            id="ca-accordion-trigger-1"
                            data-accordion-trigger
                        >
                            <span class="ca-accordion__trigger-text ca-card-title">{{ $data['verification']['title'] }}</span>
                            <span class="ca-accordion__icon" data-lucide="chevron-down" aria-hidden="true"></span>
                        </button>
                    </h3>
                    <div
                        id="ca-accordion-panel-1"
                        class="ca-accordion__panel"
                        role="region"
                        aria-labelledby="ca-accordion-trigger-1"
                        data-accordion-panel
                    >
                        <ul class="ca-accordion__list ca-list-reset">
                            @foreach ($data['verification']['items'] as $item)
                                <li>{{ $item['text'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($data['payment']['is_active'])
                <div class="ca-accordion__item">
                    <h3 class="ca-accordion__heading">
                        <button
                            type="button"
                            class="ca-accordion__trigger"
                            aria-expanded="true"
                            aria-controls="ca-accordion-panel-2"
                            id="ca-accordion-trigger-2"
                            data-accordion-trigger
                        >
                            <span class="ca-accordion__trigger-text ca-card-title">{{ $data['payment']['title'] }}</span>
                            <span class="ca-accordion__icon" data-lucide="chevron-down" aria-hidden="true"></span>
                        </button>
                    </h3>
                    <div
                        id="ca-accordion-panel-2"
                        class="ca-accordion__panel"
                        role="region"
                        aria-labelledby="ca-accordion-trigger-2"
                        data-accordion-panel
                    >
                        <ul class="ca-accordion__list ca-list-reset">
                            @foreach ($data['payment']['items'] as $item)
                                <li>{{ $item['text'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($data['cancellation']['is_active'])
                <div class="ca-accordion__item">
                    <h3 class="ca-accordion__heading">
                        <button
                            type="button"
                            class="ca-accordion__trigger"
                            aria-expanded="true"
                            aria-controls="ca-accordion-panel-3"
                            id="ca-accordion-trigger-3"
                            data-accordion-trigger
                        >
                            <span class="ca-accordion__trigger-text ca-card-title">{{ $data['cancellation']['title'] }}</span>
                            <span class="ca-accordion__icon" data-lucide="chevron-down" aria-hidden="true"></span>
                        </button>
                    </h3>
                    <div
                        id="ca-accordion-panel-3"
                        class="ca-accordion__panel"
                        role="region"
                        aria-labelledby="ca-accordion-trigger-3"
                        data-accordion-panel
                    >
                        <p class="ca-accordion__text ca-body-sm">
                            {{ $data['cancellation']['description'] }}
                        </p>
                    </div>
                </div>
            @endif

            @if ($data['rights_obligations']['is_active'])
                <div class="ca-accordion__item">
                    <h3 class="ca-accordion__heading">
                        <button
                            type="button"
                            class="ca-accordion__trigger"
                            aria-expanded="true"
                            aria-controls="ca-accordion-panel-4"
                            id="ca-accordion-trigger-4"
                            data-accordion-trigger
                        >
                            <span class="ca-accordion__trigger-text ca-card-title">{{ $data['rights_obligations']['title'] }}</span>
                            <span class="ca-accordion__icon" data-lucide="chevron-down" aria-hidden="true"></span>
                        </button>
                    </h3>
                    <div
                        id="ca-accordion-panel-4"
                        class="ca-accordion__panel"
                        role="region"
                        aria-labelledby="ca-accordion-trigger-4"
                        data-accordion-panel
                    >
                        <div class="ca-accordion__grid">
                            @foreach ($data['rights_obligations']['items'] as $item)
                                <div>
                                    <span class="ca-accordion__grid-label ca-label">{{ $item['label'] }}</span>
                                    <p class="ca-body-sm">{{ $item['text'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if ($data['operational_terms']['is_active'])
                <div class="ca-accordion__item">
                    <h3 class="ca-accordion__heading">
                        <button
                            type="button"
                            class="ca-accordion__trigger"
                            aria-expanded="true"
                            aria-controls="ca-accordion-panel-5"
                            id="ca-accordion-trigger-5"
                            data-accordion-trigger
                        >
                            <span class="ca-accordion__trigger-text ca-card-title">{{ $data['operational_terms']['title'] }}</span>
                            <span class="ca-accordion__icon" data-lucide="chevron-down" aria-hidden="true"></span>
                        </button>
                    </h3>
                    <div
                        id="ca-accordion-panel-5"
                        class="ca-accordion__panel"
                        role="region"
                        aria-labelledby="ca-accordion-trigger-5"
                        data-accordion-panel
                    >
                        <ul class="ca-accordion__list ca-list-reset">
                            @foreach ($data['operational_terms']['items'] as $item)
                                <li>{{ $item['text'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <div class="ca-terms__cta">
            <h2 class="ca-terms__cta-title ca-section-title">{{ $data['cta_title'] }}</h2>
            <p class="ca-terms__cta-description ca-body">
                {{ $data['cta_description'] }}
            </p>
            <div class="ca-terms__cta-actions ca-cluster">
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
        </div>
    </div>
</section>
