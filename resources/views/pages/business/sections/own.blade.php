{{-- SECTION 2 — OWN: Mitra Memiliki Aset --}}
<section id="own" class="ca-own">
    <div class="ca-container ca-own__inner" data-reveal>
        <div class="ca-own__visual">
            <div class="ca-own__frame">
                @if ($data['image']['url'])
                    <img
                        src="{{ $data['image']['url'] }}"
                        alt="{{ $data['image']['alt'] }}"
                        width="1400"
                        height="2100"
                        loading="lazy"
                        decoding="async"
                        class="ca-own__image"
                    >
                @endif

                <div class="ca-own__badge">
                    <span class="ca-own__badge-icon" data-lucide="badge-check" aria-hidden="true"></span>
                    <span class="ca-own__badge-text ca-label">Aset Milik Mitra</span>
                </div>
            </div>

            <p class="ca-own__visual-caption ca-caption">Visualisasi Konsep Kepemilikan</p>
        </div>

        <div class="ca-own__content">
            @if ($data['eyebrow'])
                <span class="ca-own__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif

            <h2 class="ca-own__title ca-section-title">
                {{ $data['title'] }}
            </h2>

            <p class="ca-own__description ca-body">
                {{ $data['description'] }}
            </p>

            @php
                $ownPointIcons = [0 => 'key-round', 1 => 'file-check', 2 => 'shield-check', 3 => 'badge-check'];
            @endphp
            @if ($data['key_points'])
                <ul class="ca-own__points ca-list-reset">
                    @foreach ($data['key_points'] as $slot => $point)
                        <li class="ca-own__point">
                            <span class="ca-own__point-icon" data-lucide="{{ $ownPointIcons[$slot] ?? 'key-round' }}" aria-hidden="true"></span>
                            <span class="ca-body-sm">{{ $point['text'] }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
