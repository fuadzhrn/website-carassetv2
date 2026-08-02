{{-- SECTION 1 — Dasar Perhitungan Operasional (Simulation Control Panel) --}}
<section id="dasar-perhitungan" class="ca-assumptions" aria-labelledby="ca-simulation-heading">
    <div class="ca-container">
        <div class="ca-assumptions__header">
            @if ($data['eyebrow'])
                <span class="ca-assumptions__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif

            <h1 id="ca-simulation-heading" class="ca-assumptions__title ca-page-title">
                {{ $data['title'] }}
            </h1>

            <p class="ca-assumptions__description ca-body-lg">
                {{ $data['description'] }}
            </p>

            <span class="ca-simulation-status">
                <span class="ca-simulation-status__icon" data-lucide="info" aria-hidden="true"></span>
                {{ $data['data_status'] === 'confirmed' ? 'Telah Dikonfirmasi' : 'Menunggu Konfirmasi' }}
            </span>
        </div>

        <div class="ca-assumptions__panel ca-simulation-panel">
            <div class="ca-assumptions__zone">
                <h3 class="ca-assumptions__zone-title ca-card-title">Aktivitas Operasional</h3>

                <dl class="ca-assumptions__list">
                    <div class="ca-assumptions__item">
                        <dt class="ca-simulation-label">{{ $data['fields']['operational_days']['label'] }}</dt>
                        <dd class="ca-simulation-value {{ $data['fields']['operational_days']['amount']['is_available'] ? 'is-final' : 'is-pending' }}">
                            {{ $data['fields']['operational_days']['amount']['is_available'] ? $data['fields']['operational_days']['amount']['formatted_value'] : 'Menunggu angka final klien' }}
                        </dd>
                    </div>
                    <div class="ca-assumptions__item">
                        <dt class="ca-simulation-label">{{ $data['fields']['daily_result']['label'] }}</dt>
                        <dd class="ca-simulation-value {{ $data['fields']['daily_result']['amount']['is_available'] ? 'is-final' : 'is-pending' }}">
                            {{ $data['fields']['daily_result']['amount']['is_available'] ? $data['fields']['daily_result']['amount']['formatted_value'] : 'Menunggu angka final klien' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="ca-assumptions__divider" aria-hidden="true"></div>

            <div class="ca-assumptions__zone">
                <h3 class="ca-assumptions__zone-title ca-card-title">Kewajiban dan Biaya</h3>

                <dl class="ca-assumptions__list">
                    <div class="ca-assumptions__item">
                        <dt class="ca-simulation-label">{{ $data['fields']['operating_cost']['label'] }}</dt>
                        <dd class="ca-simulation-value {{ $data['fields']['operating_cost']['amount']['is_available'] ? 'is-final' : 'is-pending' }}">
                            {{ $data['fields']['operating_cost']['amount']['is_available'] ? $data['fields']['operating_cost']['amount']['formatted_value'] : 'Menunggu angka final klien' }}
                        </dd>
                    </div>
                    <div class="ca-assumptions__item">
                        <dt class="ca-simulation-label">{{ $data['fields']['vehicle_installment']['label'] }}</dt>
                        <dd class="ca-simulation-value {{ $data['fields']['vehicle_installment']['amount']['is_available'] ? 'is-final' : 'is-pending' }}">
                            {{ $data['fields']['vehicle_installment']['amount']['is_available'] ? $data['fields']['vehicle_installment']['amount']['formatted_value'] : 'Menunggu angka final klien' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="ca-assumptions__divider" aria-hidden="true"></div>

            <div class="ca-assumptions__zone">
                <h3 class="ca-assumptions__zone-title ca-card-title">Pengelolaan dan Pembagian</h3>

                <dl class="ca-assumptions__list">
                    <div class="ca-assumptions__item">
                        <dt class="ca-simulation-label">{{ $data['fields']['management_component']['label'] }}</dt>
                        <dd class="ca-simulation-value {{ $data['fields']['management_component']['amount']['is_available'] ? 'is-final' : 'is-pending' }}">
                            {{ $data['fields']['management_component']['amount']['is_available'] ? $data['fields']['management_component']['amount']['formatted_value'] : 'Menunggu angka final klien' }}
                        </dd>
                    </div>
                    <div class="ca-assumptions__item">
                        <dt class="ca-simulation-label">{{ $data['fields']['revenue_share']['label'] }}</dt>
                        <dd class="ca-simulation-value {{ $data['fields']['revenue_share']['amount']['is_available'] ? 'is-final' : 'is-pending' }}">
                            {{ $data['fields']['revenue_share']['amount']['is_available'] ? $data['fields']['revenue_share']['amount']['formatted_value'] : 'Menunggu angka final klien' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        @if ($data['callout']['is_active'] && $data['callout']['description'])
            <p class="ca-assumptions__note ca-simulation-note">
                {{ $data['callout']['description'] }}
            </p>
        @endif

        <a href="#simulasi-satu-unit" class="ca-assumptions__cta ca-nav-text">
            Lihat Alur Simulasi 1 Unit
            <span class="ca-assumptions__cta-icon" data-lucide="arrow-down" aria-hidden="true"></span>
        </a>
    </div>
</section>
