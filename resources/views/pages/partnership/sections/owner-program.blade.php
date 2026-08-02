{{-- SECTION 2 — Program Mitra Owner (Ownership Architecture) --}}
<section id="mitra-owner" class="ca-owner-program">
    <div class="ca-container">
        <x-section-heading
            align="center"
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['narrative']"
        />

        <div class="ca-owner-program__stage">
            <div class="ca-owner-program__frame">
                <img
                    src="{{ $data['image']['url'] }}"
                    alt="{{ $data['image']['alt'] }}"
                    width="1600"
                    height="1067"
                    loading="lazy"
                    decoding="async"
                    class="ca-owner-program__image"
                >
            </div>

            @php
                $calloutIcons = [0 => 'key-round', 1 => 'settings', 2 => 'activity', 3 => 'wrench'];
                $calloutPositions = [0 => 'tl', 1 => 'tr', 2 => 'bl', 3 => 'br'];
            @endphp
            @foreach ($data['callouts'] as $slot => $callout)
                <div class="ca-owner-program__callout ca-owner-program__callout--{{ $calloutPositions[$slot] ?? 'tl' }}">
                    <span class="ca-owner-program__callout-icon" data-lucide="{{ $calloutIcons[$slot] ?? 'key-round' }}" aria-hidden="true"></span>
                    <span class="ca-owner-program__callout-label ca-label">{{ $callout['label'] }}</span>
                </div>
            @endforeach
        </div>

        <p class="ca-owner-program__stage-caption ca-caption">Visualisasi Struktur Program Mitra Owner</p>

        <div class="ca-owner-program__roles">
            <div class="ca-owner-program__role">
                <h3 class="ca-owner-program__role-title ca-card-title">
                    <span class="ca-owner-program__role-icon" data-lucide="user" aria-hidden="true"></span>
                    Peran Mitra
                </h3>
                <ul class="ca-owner-program__role-list ca-list-reset">
                    @foreach ($data['partner_roles'] as $role)
                        <li>{{ $role['text'] }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="ca-owner-program__role-divider" aria-hidden="true"></div>

            <div class="ca-owner-program__role">
                <h3 class="ca-owner-program__role-title ca-card-title">
                    <span class="ca-owner-program__role-icon" data-lucide="building-2" aria-hidden="true"></span>
                    Peran CarAsset
                </h3>
                <ul class="ca-owner-program__role-list ca-list-reset">
                    @foreach ($data['carasset_roles'] as $role)
                        <li>{{ $role['text'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <ul class="ca-owner-program__benefits ca-list-reset">
            @foreach ($data['benefits'] as $benefit)
                <li class="ca-owner-program__benefit">
                    <span class="ca-owner-program__benefit-icon" data-lucide="badge-check" aria-hidden="true"></span>
                    <span class="ca-body-sm">{{ $benefit['text'] }}</span>
                </li>
            @endforeach
        </ul>

        <div class="ca-owner-program__cta">
            @if ($data['cta'])
                <x-button href="{{ $data['cta']['url'] }}" target="{{ $data['cta']['target'] }}" variant="secondary" size="md">
                    {{ $data['cta']['label'] }}
                </x-button>
            @endif
            <p class="ca-owner-program__microcopy ca-body-sm">
                {{ $data['microcopy'] }}
            </p>
        </div>
    </div>
</section>
