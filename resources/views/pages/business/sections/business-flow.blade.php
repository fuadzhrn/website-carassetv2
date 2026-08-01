{{-- SECTION 5 — Alur Bisnis CarAsset --}}
<section id="alur-bisnis" class="ca-business-flow">
    <div class="ca-container">
        <x-section-heading
            align="center"
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        @php
            $flowIcons = [0 => 'messages-square', 1 => 'clipboard-check', 2 => 'car-front', 3 => 'route', 4 => 'activity'];
        @endphp
        @if ($data['stages'])
            <div class="ca-business-flow__timeline">
                <div class="ca-business-flow__track" aria-hidden="true"></div>

                @foreach ($data['stages'] as $slot => $stage)
                    <div class="ca-business-flow__step ca-business-flow__step--{{ $slot + 1 }}">
                        <span class="ca-business-flow__number" aria-hidden="true">{{ str_pad($slot + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="ca-business-flow__icon" data-lucide="{{ $flowIcons[$slot] ?? 'activity' }}" aria-hidden="true"></span>
                        <h3 class="ca-business-flow__title ca-card-title">{{ $stage['title'] }}</h3>
                        <p class="ca-business-flow__description ca-body-sm">
                            {{ $stage['description'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="ca-business-flow__footer">
            @if ($data['primary_cta'] || $data['secondary_cta'])
                <div class="ca-business-flow__actions ca-cluster">
                    @if ($data['primary_cta'])
                        <x-button href="{{ $data['primary_cta']['url'] }}" target="{{ $data['primary_cta']['target'] }}" variant="primary" size="md">
                            {{ $data['primary_cta']['label'] }}
                        </x-button>
                    @endif
                    @if ($data['secondary_cta'])
                        <x-button href="{{ $data['secondary_cta']['url'] }}" target="{{ $data['secondary_cta']['target'] }}" variant="outline" size="md">
                            {{ $data['secondary_cta']['label'] }}
                        </x-button>
                    @endif
                </div>
            @endif

            <p class="ca-business-flow__microcopy ca-body-sm">
                {{ $data['closing_statement'] }}
            </p>
        </div>
    </div>
</section>
