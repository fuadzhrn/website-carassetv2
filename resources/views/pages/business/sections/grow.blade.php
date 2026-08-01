{{-- SECTION 4 — GROW: Pengembangan Kepemilikan --}}
<section id="grow" class="ca-grow">
    <div class="ca-container">
        <div class="ca-grow__header">
            @if ($data['eyebrow'])
                <span class="ca-grow__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif

            <h2 class="ca-grow__title ca-display">{{ $data['title'] }}</h2>

            <p class="ca-grow__description ca-body-lg">
                {{ $data['description'] }}
            </p>
        </div>

        <p class="ca-grow__caption ca-caption">Ilustrasi Konsep Pertumbuhan</p>

        @if ($data['stages'])
            <div class="ca-grow__journey" data-reveal>
                <div class="ca-grow__track" aria-hidden="true"></div>

                @foreach ($data['stages'] as $slot => $stage)
                    <div class="ca-grow__stage ca-grow__stage--{{ $slot + 1 }}">
                        <span class="ca-grow__stage-marker" aria-hidden="true"></span>
                        @if ($stage['label'] ?? null)
                            <span class="ca-grow__stage-eyebrow ca-label">{{ $stage['label'] }}</span>
                        @endif
                        <h3 class="ca-grow__stage-title ca-card-title">{{ $stage['title'] }}</h3>
                    </div>
                @endforeach
            </div>
        @endif

        <p class="ca-grow__disclaimer ca-disclaimer-text">
            Pertumbuhan unit merupakan ilustrasi konsep dan bukan jaminan hasil.
            Realisasi bergantung pada kondisi operasional, pembiayaan, nilai aset,
            dan ketentuan yang berlaku.
        </p>

        @if ($data['cta'])
            <div class="ca-grow__cta">
                <x-button href="{{ $data['cta']['url'] }}" target="{{ $data['cta']['target'] }}" variant="outline" size="md">
                    {{ $data['cta']['label'] }}
                </x-button>
            </div>
        @endif
    </div>
</section>
