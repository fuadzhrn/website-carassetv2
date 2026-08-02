{{-- SECTION 2 — Visi, Misi & Nilai (Brand Direction & Value Constellation) --}}
<section id="visi-misi-nilai" class="ca-vision" aria-labelledby="ca-vision-heading">
    <div class="ca-container">
        <div class="ca-vision__statement-block">
            @if ($data['vision']['label'])
                <span class="ca-vision__eyebrow ca-eyebrow">{{ $data['vision']['label'] }}</span>
            @endif

            @if ($data['vision']['is_confirmed'] && $data['vision']['statement'])
                <h2 id="ca-vision-heading" class="ca-vision__statement ca-display">
                    {{ $data['vision']['statement'] }}
                </h2>
            @else
                <h2 id="ca-vision-heading" class="ca-vision__statement ca-display">
                    Pernyataan visi CarAsset sedang dalam proses penyusunan resmi.
                </h2>
                <span class="ca-vision__note ca-caption">Redaksi visi menunggu persetujuan final perusahaan.</span>
            @endif
        </div>

        <div class="ca-vision__mission-block">
            @if ($data['mission']['label'])
                <span class="ca-vision__eyebrow ca-eyebrow">{{ $data['mission']['label'] }}</span>
            @endif

            @if ($data['mission']['is_confirmed'] && $data['mission']['items'])
                <ol class="ca-vision__mission-list">
                    @foreach ($data['mission']['items'] as $item)
                        <li>
                            <span class="ca-vision__mission-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="ca-body">{{ $item['text'] }}</span>
                        </li>
                    @endforeach
                </ol>
            @else
                <p class="ca-body">Misi CarAsset sedang dalam proses penyusunan resmi.</p>
                <span class="ca-vision__note ca-caption">Redaksi misi menunggu persetujuan final perusahaan.</span>
            @endif
        </div>

        @if ($data['values'])
            <div class="ca-vision__values">
                <h3 class="ca-vision__values-heading ca-visually-hidden">Nilai Utama CarAsset</h3>

                <div class="ca-vision__track" aria-hidden="true"></div>

                @php
                    $valueIcons = [
                        'trust' => ['icon' => 'shield-check', 'gold' => false],
                        'growth' => ['icon' => 'trending-up', 'gold' => true],
                        'productive' => ['icon' => 'route', 'gold' => false],
                        'partnership' => ['icon' => 'users', 'gold' => true],
                    ];
                    $valueTranslations = [
                        'trust' => 'Kepercayaan',
                        'growth' => 'Pertumbuhan',
                        'productive' => 'Produktif',
                        'partnership' => 'Kemitraan',
                    ];
                    $valuePositions = ['trust' => 1, 'growth' => 2, 'productive' => 3, 'partnership' => 4];
                @endphp
                @foreach ($data['values'] as $valueKey => $value)
                    <div class="ca-vision__value ca-vision__value--{{ $valuePositions[$valueKey] ?? 1 }}">
                        <span class="ca-vision__value-icon{{ ($valueIcons[$valueKey]['gold'] ?? false) ? ' ca-vision__value-icon--gold' : '' }}" data-lucide="{{ $valueIcons[$valueKey]['icon'] ?? 'shield-check' }}" aria-hidden="true"></span>
                        <span class="ca-vision__value-eyebrow">{{ strtoupper($value['title']) }}</span>
                        <h3 class="ca-vision__value-title">{{ $valueTranslations[$valueKey] ?? $value['title'] }}</h3>
                        @if ($value['description'])
                            <p class="ca-vision__value-description">
                                {{ $value['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
