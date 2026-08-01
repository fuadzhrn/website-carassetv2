{{-- SECTION 5 — CTA Konsultasi --}}
<section id="konsultasi-home" class="ca-consultation">
    <div class="ca-consultation__route" aria-hidden="true"></div>

    <div class="ca-container ca-consultation__inner" data-reveal>
        <div class="ca-consultation__content">
            <x-section-heading
                theme="dark"
                :eyebrow="$data['eyebrow']"
                :title="$data['title']"
                :description="$data['description']"
            />

            @if ($data['primary_cta'] || $data['secondary_cta'])
                <div class="ca-consultation__actions ca-cluster">
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
            @endif

            @if ($data['microcopy'])
                <p class="ca-consultation__microcopy ca-body-sm">
                    {{ $data['microcopy'] }}
                </p>
            @endif
        </div>

        @php
            $trustIcons = [0 => 'badge-check', 1 => 'settings', 2 => 'activity', 3 => 'route'];
        @endphp
        @if ($data['trust_points'])
            <ul class="ca-consultation__trust ca-list-reset">
                @foreach ($data['trust_points'] as $slot => $point)
                    <li class="ca-consultation__trust-item">
                        <span class="ca-consultation__trust-icon" data-lucide="{{ $trustIcons[$slot] ?? 'badge-check' }}" aria-hidden="true"></span>
                        <span>{{ $point['text'] }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</section>
