{{-- SECTION 3 — Cara Singkat CarAsset Bekerja (Own – Operate – Grow) --}}
<section id="cara-kerja" class="ca-process">
    <div class="ca-container">
        <x-section-heading
            align="center"
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        @php
            $processStepMeta = [
                'own' => ['number' => '01', 'icon' => 'key-round'],
                'operate' => ['number' => '02', 'icon' => 'settings'],
                'grow' => ['number' => '03', 'icon' => 'trending-up'],
            ];
        @endphp

        @if ($data['steps'])
            <div class="ca-process__timeline" data-process-journey>
                <div class="ca-process__track" aria-hidden="true"></div>

                @foreach ($data['steps'] as $stepKey => $step)
                    <div class="ca-process__step ca-process__step--{{ $stepKey }}" data-process-step>
                        <span class="ca-process__number" aria-hidden="true">{{ $processStepMeta[$stepKey]['number'] }}</span>
                        <span class="ca-process__icon" data-lucide="{{ $processStepMeta[$stepKey]['icon'] }}" aria-hidden="true"></span>
                        <h3 class="ca-process__title ca-card-title">{{ $step['title'] }}</h3>
                        <p class="ca-process__description ca-body-sm">
                            {{ $step['description'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($data['cta'])
            <div class="ca-process__cta">
                <x-button href="{{ $data['cta']['url'] }}" target="{{ $data['cta']['target'] }}" variant="outline" size="md">
                    {{ $data['cta']['label'] }}
                </x-button>
            </div>
        @endif
    </div>
</section>
