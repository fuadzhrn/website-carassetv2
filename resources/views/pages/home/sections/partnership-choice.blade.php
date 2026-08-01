{{-- SECTION 4 — Pilihan Program Kemitraan --}}
<section class="ca-partnership-choice">
    <div class="ca-container">
        <x-section-heading
            align="center"
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        @php
            $ownerBenefitIcons = [0 => 'key-round', 1 => 'settings', 2 => 'activity', 3 => 'badge-check'];
            $driverBenefitIcons = [0 => 'route', 1 => 'settings', 2 => 'trending-up', 3 => 'badge-check'];
        @endphp

        <div class="ca-partnership-choice__grid" data-reveal>
            <article class="ca-partnership-panel ca-partnership-panel--owner">
                @if ($data['owner']['image']['url'])
                    <img
                        src="{{ $data['owner']['image']['url'] }}"
                        alt="{{ $data['owner']['image']['alt'] }}"
                        width="1400"
                        height="2100"
                        loading="lazy"
                        decoding="async"
                        class="ca-partnership-panel__image"
                    >
                @endif
                <div class="ca-partnership-panel__overlay" aria-hidden="true"></div>

                <div class="ca-partnership-panel__content">
                    @if ($data['owner']['eyebrow'])
                        <span class="ca-partnership-panel__eyebrow ca-eyebrow">{{ $data['owner']['eyebrow'] }}</span>
                    @endif
                    <h3 class="ca-partnership-panel__title ca-page-title">{{ $data['owner']['title'] }}</h3>
                    <p class="ca-partnership-panel__description ca-body">
                        {{ $data['owner']['description'] }}
                    </p>

                    @if ($data['owner']['benefits'])
                        <ul class="ca-partnership-panel__benefits ca-list-reset">
                            @foreach ($data['owner']['benefits'] as $slot => $benefit)
                                <li>
                                    <span class="ca-partnership-panel__benefit-icon" data-lucide="{{ $ownerBenefitIcons[$slot] ?? 'key-round' }}" aria-hidden="true"></span>
                                    {{ $benefit['text'] }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if ($data['owner']['cta'])
                        <x-button href="{{ $data['owner']['cta']['url'] }}" target="{{ $data['owner']['cta']['target'] }}" variant="gold" size="md">
                            {{ $data['owner']['cta']['label'] }}
                        </x-button>
                    @endif
                </div>
            </article>

            <article class="ca-partnership-panel ca-partnership-panel--driver">
                @if ($data['driver']['image']['url'])
                    <img
                        src="{{ $data['driver']['image']['url'] }}"
                        alt="{{ $data['driver']['image']['alt'] }}"
                        width="1400"
                        height="935"
                        loading="lazy"
                        decoding="async"
                        class="ca-partnership-panel__image"
                    >
                @endif
                <div class="ca-partnership-panel__overlay" aria-hidden="true"></div>

                <div class="ca-partnership-panel__content">
                    @if ($data['driver']['eyebrow'])
                        <span class="ca-partnership-panel__eyebrow ca-eyebrow">{{ $data['driver']['eyebrow'] }}</span>
                    @endif
                    <h3 class="ca-partnership-panel__title ca-page-title">{{ $data['driver']['title'] }}</h3>
                    <p class="ca-partnership-panel__description ca-body">
                        {{ $data['driver']['description'] }}
                    </p>

                    @if ($data['driver']['benefits'])
                        <ul class="ca-partnership-panel__benefits ca-list-reset">
                            @foreach ($data['driver']['benefits'] as $slot => $benefit)
                                <li>
                                    <span class="ca-partnership-panel__benefit-icon" data-lucide="{{ $driverBenefitIcons[$slot] ?? 'route' }}" aria-hidden="true"></span>
                                    {{ $benefit['text'] }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if ($data['driver']['cta'])
                        <x-button href="{{ $data['driver']['cta']['url'] }}" target="{{ $data['driver']['cta']['target'] }}" variant="primary" size="md">
                            {{ $data['driver']['cta']['label'] }}
                        </x-button>
                    @endif
                </div>
            </article>
        </div>
    </div>
</section>
