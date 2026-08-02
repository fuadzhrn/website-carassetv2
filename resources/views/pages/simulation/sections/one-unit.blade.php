{{-- SECTION 2 — Simulasi 1 Unit (Operational Cash-Flow Journey) --}}
<section id="simulasi-satu-unit" class="ca-one-unit">
    <div class="ca-container">
        <x-section-heading
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        <span class="ca-simulation-status">
            <span class="ca-simulation-status__icon" data-lucide="info" aria-hidden="true"></span>
            {{ $data['data_status'] === 'confirmed' ? 'Telah Dikonfirmasi' : 'Menunggu Konfirmasi' }}
        </span>

        @php
            $nodeIcons = [
                'gross_operational_result' => 'wallet-cards',
                'operating_cost' => 'receipt-text',
                'vehicle_obligation' => 'landmark',
                'management_component' => 'settings',
                'projected_partner_result' => 'chart-no-axes-combined',
            ];
            $nodeDescriptions = [
                'gross_operational_result' => 'Nilai sebelum dikurangi komponen biaya dan kewajiban.',
                'operating_cost' => 'Mencakup komponen biaya yang telah ditetapkan dalam program.',
                'vehicle_obligation' => 'Mencakup cicilan atau kewajiban kendaraan sesuai skema pembiayaan.',
                'management_component' => 'Mengikuti sistem pengelolaan dan pembagian yang disepakati.',
                'projected_partner_result' => 'Nilai ini merupakan ilustrasi, bukan jaminan hasil.',
            ];
        @endphp

        <div class="ca-one-unit__flow">
            <div class="ca-one-unit__track ca-simulation-flow-line" aria-hidden="true"></div>

            <div class="ca-one-unit__node">
                <span class="ca-one-unit__node-icon" data-lucide="car-front" aria-hidden="true"></span>
                <h3 class="ca-one-unit__node-title ca-card-title">Aktivitas Kendaraan</h3>
                <p class="ca-one-unit__node-description ca-body-sm">
                    Kendaraan menjalankan aktivitas operasional sesuai jadwal dan
                    sistem yang berlaku.
                </p>
            </div>

            @foreach (['gross_operational_result', 'operating_cost', 'vehicle_obligation', 'management_component', 'projected_partner_result'] as $field)
                @php $isResult = $field === 'projected_partner_result'; @endphp
                <div class="ca-one-unit__node{{ $isResult ? ' ca-one-unit__node--result' : '' }}">
                    <span class="ca-one-unit__node-icon" data-lucide="{{ $nodeIcons[$field] }}" aria-hidden="true"></span>
                    <h3 class="ca-one-unit__node-title ca-card-title">{{ $data['fields'][$field]['label'] }}</h3>
                    <p class="ca-one-unit__node-value ca-simulation-value {{ $data['fields'][$field]['amount']['is_available'] ? 'is-final' : 'is-pending' }}">
                        {{ $data['fields'][$field]['amount']['is_available'] ? $data['fields'][$field]['amount']['formatted_value'] : 'Menunggu angka final klien' }}
                    </p>
                    <p class="ca-one-unit__node-description ca-body-sm">
                        {{ $nodeDescriptions[$field] }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="ca-one-unit__summary ca-simulation-panel">
            <div class="ca-one-unit__summary-item">
                <span class="ca-simulation-label">Jumlah Unit</span>
                <span class="ca-simulation-value is-final">1 Unit</span>
            </div>
            <div class="ca-one-unit__summary-item">
                <span class="ca-simulation-label">Status Data</span>
                <span class="ca-simulation-value {{ $data['data_status'] === 'confirmed' ? 'is-final' : 'is-pending' }}">
                    {{ $data['data_status'] === 'confirmed' ? 'Telah Dikonfirmasi' : 'Menunggu konfirmasi final' }}
                </span>
            </div>
            <div class="ca-one-unit__summary-item">
                <span class="ca-simulation-label">Jenis Tampilan</span>
                <span class="ca-simulation-value is-final">Ilustrasi Proyeksi Operasional</span>
            </div>
            <div class="ca-one-unit__summary-item">
                <span class="ca-simulation-label">Catatan</span>
                <span class="ca-simulation-value is-final">{{ $data['summary_note'] }}</span>
            </div>
        </div>

        @if ($data['cta'])
            <div class="ca-one-unit__cta">
                <x-button href="{{ $data['cta']['url'] }}" target="{{ $data['cta']['target'] }}" variant="primary" size="md">
                    {{ $data['cta']['label'] }}
                </x-button>
            </div>
        @endif
    </div>
</section>
