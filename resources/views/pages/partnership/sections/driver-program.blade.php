{{-- SECTION 3 — Program Mitra Driver (Road to Ownership) --}}
<section id="mitra-driver" class="ca-driver-program">
    <div class="ca-container">
        <div class="ca-driver-program__intro">
            <div class="ca-driver-program__intro-content">
                @if ($data['eyebrow'])
                    <span class="ca-driver-program__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
                @endif

                <h2 class="ca-driver-program__title ca-section-title">
                    {!! nl2br(e($data['title'])) !!}
                </h2>

                <p class="ca-driver-program__description ca-body">
                    {{ $data['narrative'] }}
                </p>
            </div>

            <div class="ca-driver-program__intro-visual">
                <img
                    src="{{ $data['image']['url'] }}"
                    alt="{{ $data['image']['alt'] }}"
                    width="1600"
                    height="1068"
                    loading="lazy"
                    decoding="async"
                    class="ca-driver-program__image"
                >
            </div>
        </div>

        @php
            $milestoneIcons = [0 => 'user-check', 1 => 'car-front', 2 => 'wallet-cards', 3 => 'clipboard-check', 4 => 'key-round'];
        @endphp
        <div class="ca-driver-program__timeline" data-driver-journey>
            <div class="ca-driver-program__track" aria-hidden="true"></div>

            @foreach ($data['timeline'] as $slot => $milestone)
                <div class="ca-driver-program__milestone" data-driver-milestone>
                    <span class="ca-driver-program__milestone-dot{{ $slot === 4 ? ' ca-driver-program__milestone-dot--gold' : '' }}" aria-hidden="true">
                        <span class="ca-driver-program__milestone-icon" data-lucide="{{ $milestoneIcons[$slot] ?? 'user-check' }}" aria-hidden="true"></span>
                    </span>
                    <span class="ca-driver-program__milestone-eyebrow ca-label">{{ $milestone['label'] }}</span>
                    <h3 class="ca-driver-program__milestone-title ca-card-title">{{ $milestone['title'] }}</h3>
                    <p class="ca-driver-program__milestone-description ca-body-sm">
                        {{ $milestone['description'] }}
                    </p>
                </div>
            @endforeach
        </div>

        @if ($data['after_unit_panel']['is_active'])
            <div class="ca-driver-program__after">
                <h3 class="ca-driver-program__after-title ca-card-title">{{ $data['after_unit_panel']['title'] }}</h3>
                <p class="ca-driver-program__after-lead ca-body-sm">
                    {{ $data['after_unit_panel']['description'] }}
                </p>
                <ul class="ca-driver-program__after-list ca-list-reset">
                    @foreach ($data['after_unit_panel']['items'] as $item)
                        <li>{{ $item['text'] }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="ca-driver-program__cta">
            @if ($data['cta'])
                <x-button href="{{ $data['cta']['url'] }}" target="{{ $data['cta']['target'] }}" variant="primary" size="md">
                    {{ $data['cta']['label'] }}
                </x-button>
            @endif
            <p class="ca-driver-program__note ca-disclaimer-text">
                {{ $data['note'] }}
            </p>
        </div>
    </div>
</section>
