{{-- SECTION 3 — Simulasi Beberapa Unit (Scenario Comparison Rail) --}}
<section id="simulasi-beberapa-unit" class="ca-multiple-units">
    <div class="ca-container">
        <x-section-heading
            theme="dark"
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        <span class="ca-simulation-status ca-simulation-status--dark">
            <span class="ca-simulation-status__icon" data-lucide="info" aria-hidden="true"></span>
            {{ $data['data_status'] === 'confirmed' ? 'Telah Dikonfirmasi' : 'Menunggu Konfirmasi' }}
        </span>

        @php
            $metricLabels = [
                'gross_operational_result' => 'Hasil operasional bruto',
                'operating_cost' => 'Biaya operasional',
                'vehicle_obligation' => 'Kewajiban kendaraan',
                'management_component' => 'Komponen pengelolaan',
                'projected_partner_result' => 'Proyeksi hasil mitra',
            ];
        @endphp

        <div class="ca-multiple-units__rail">
            <div class="ca-multiple-units__track" aria-hidden="true"></div>

            @foreach ($data['units'] as $unitKey => $unit)
                <div class="ca-multiple-units__scenario">
                    <span class="ca-multiple-units__label ca-label">{{ $unit['label'] }}</span>
                    <h3 class="ca-multiple-units__unit ca-page-title">{{ $unit['unit_count'] }} Unit</h3>

                    @if ($unitKey !== 'one_unit')
                        <span class="ca-multiple-units__estimate-badge">
                            <span class="ca-multiple-units__estimate-icon" data-lucide="calculator" aria-hidden="true"></span>
                            Estimasi Linear — Bukan Angka Resmi
                        </span>
                    @endif

                    <ul class="ca-multiple-units__rows ca-list-reset">
                        @foreach ($metricLabels as $metric => $metricLabel)
                            <li>
                                <span class="ca-simulation-label">{{ $metricLabel }}</span>
                                <span class="ca-simulation-value {{ $unit['fields'][$metric]['is_available'] ? 'is-final' : 'is-pending' }}">
                                    {{ $unit['fields'][$metric]['is_available'] ? $unit['fields'][$metric]['formatted_value'] : 'Menunggu angka final klien' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <p class="ca-multiple-units__warning ca-simulation-note ca-simulation-note--dark">
            {{ $data['comparison_note'] }}
        </p>

        @if ($data['cta'])
            <div class="ca-multiple-units__cta">
                <x-button href="{{ $data['cta']['url'] }}" target="{{ $data['cta']['target'] }}" variant="primary" size="md">
                    {{ $data['cta']['label'] }}
                </x-button>
            </div>
        @endif
    </div>
</section>
