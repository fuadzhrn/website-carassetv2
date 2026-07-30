{{-- SECTION 2 — Simulasi 1 Unit (Operational Cash-Flow Journey) --}}
<section id="simulasi-satu-unit" class="ca-one-unit">
    <div class="ca-container">
        <x-section-heading
            eyebrow="Ilustrasi Satu Unit"
            title="Melihat Alur Operasional dari Satu Kendaraan."
            description="Ilustrasi ini menunjukkan bagaimana hasil operasional satu kendaraan dialokasikan ke berbagai komponen sesuai skema program."
        />

        <span class="ca-simulation-status">
            <span class="ca-simulation-status__icon" data-lucide="info" aria-hidden="true"></span>
            Contoh tampilan
        </span>

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

            <div class="ca-one-unit__node">
                <span class="ca-one-unit__node-icon" data-lucide="wallet-cards" aria-hidden="true"></span>
                <h3 class="ca-one-unit__node-title ca-card-title">Hasil Operasional Bruto</h3>
                <p
                    class="ca-one-unit__node-value ca-simulation-value is-pending"
                    data-simulation-field="scenarios.oneUnit.grossOperationalResult"
                    data-simulation-format="currency"
                >Menunggu angka final klien</p>
                <p class="ca-one-unit__node-description ca-body-sm">
                    Nilai sebelum dikurangi komponen biaya dan kewajiban.
                </p>
            </div>

            <div class="ca-one-unit__node">
                <span class="ca-one-unit__node-icon" data-lucide="receipt-text" aria-hidden="true"></span>
                <h3 class="ca-one-unit__node-title ca-card-title">Biaya Operasional</h3>
                <p
                    class="ca-one-unit__node-value ca-simulation-value is-pending"
                    data-simulation-field="scenarios.oneUnit.operationalCost"
                    data-simulation-format="currency"
                >Menunggu angka final klien</p>
                <p class="ca-one-unit__node-description ca-body-sm">
                    Mencakup komponen biaya yang telah ditetapkan dalam program.
                </p>
            </div>

            <div class="ca-one-unit__node">
                <span class="ca-one-unit__node-icon" data-lucide="landmark" aria-hidden="true"></span>
                <h3 class="ca-one-unit__node-title ca-card-title">Kewajiban Kendaraan</h3>
                <p
                    class="ca-one-unit__node-value ca-simulation-value is-pending"
                    data-simulation-field="scenarios.oneUnit.installment"
                    data-simulation-format="currency"
                >Menunggu angka final klien</p>
                <p class="ca-one-unit__node-description ca-body-sm">
                    Mencakup cicilan atau kewajiban kendaraan sesuai skema
                    pembiayaan.
                </p>
            </div>

            <div class="ca-one-unit__node">
                <span class="ca-one-unit__node-icon" data-lucide="settings" aria-hidden="true"></span>
                <h3 class="ca-one-unit__node-title ca-card-title">Komponen Pengelolaan</h3>
                <p
                    class="ca-one-unit__node-value ca-simulation-value is-pending"
                    data-simulation-field="scenarios.oneUnit.managementComponent"
                    data-simulation-format="currency"
                >Menunggu angka final klien</p>
                <p class="ca-one-unit__node-description ca-body-sm">
                    Mengikuti sistem pengelolaan dan pembagian yang disepakati.
                </p>
            </div>

            <div class="ca-one-unit__node ca-one-unit__node--result">
                <span class="ca-one-unit__node-icon" data-lucide="chart-no-axes-combined" aria-hidden="true"></span>
                <h3 class="ca-one-unit__node-title ca-card-title">Proyeksi Hasil Operasional Mitra</h3>
                <p
                    class="ca-one-unit__node-value ca-simulation-value is-pending"
                    data-simulation-field="scenarios.oneUnit.projectedOwnerResult"
                    data-simulation-format="currency"
                >Menunggu angka final klien</p>
                <p class="ca-one-unit__node-description ca-body-sm">
                    Nilai ini merupakan ilustrasi, bukan jaminan hasil.
                </p>
            </div>
        </div>

        <div class="ca-one-unit__summary ca-simulation-panel">
            <div class="ca-one-unit__summary-item">
                <span class="ca-simulation-label">Jumlah Unit</span>
                <span class="ca-simulation-value is-final">1 Unit</span>
            </div>
            <div class="ca-one-unit__summary-item">
                <span class="ca-simulation-label">Status Data</span>
                <span class="ca-simulation-value is-pending">Menunggu konfirmasi final</span>
            </div>
            <div class="ca-one-unit__summary-item">
                <span class="ca-simulation-label">Jenis Tampilan</span>
                <span class="ca-simulation-value is-final">Ilustrasi Proyeksi Operasional</span>
            </div>
            <div class="ca-one-unit__summary-item">
                <span class="ca-simulation-label">Catatan</span>
                <span class="ca-simulation-value is-final">Hasil aktual dapat berbeda.</span>
            </div>
        </div>

        <div class="ca-one-unit__cta">
            <x-button href="{{ route('about-contact') }}#contact" variant="primary" size="md">
                Konsultasikan Simulasi 1 Unit
            </x-button>
        </div>
    </div>
</section>
