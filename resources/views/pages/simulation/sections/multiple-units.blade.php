{{-- SECTION 3 — Simulasi Beberapa Unit (Scenario Comparison Rail) --}}
<section id="simulasi-beberapa-unit" class="ca-multiple-units">
    <div class="ca-container">
        <x-section-heading
            theme="dark"
            eyebrow="Perbandingan Skala Operasional"
            title="Bandingkan Struktur Simulasi untuk Beberapa Skala Unit."
            description="Perbandingan ini membantu calon mitra melihat bagaimana jumlah unit memengaruhi struktur pengelolaan. Nilai skala 5 dan 10 unit merupakan estimasi linear dari simulasi 1 unit, bukan angka resmi terpisah."
        />

        <span class="ca-simulation-status ca-simulation-status--dark">
            <span class="ca-simulation-status__icon" data-lucide="info" aria-hidden="true"></span>
            Contoh tampilan
        </span>

        <div class="ca-multiple-units__rail">
            <div class="ca-multiple-units__track" aria-hidden="true"></div>

            <div class="ca-multiple-units__scenario">
                <span class="ca-multiple-units__label ca-label">Skala Awal</span>
                <h3 class="ca-multiple-units__unit ca-page-title">1 Unit</h3>

                <ul class="ca-multiple-units__rows ca-list-reset">
                    <li>
                        <span class="ca-simulation-label">Hasil operasional bruto</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.oneUnit.grossOperationalResult" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Biaya operasional</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.oneUnit.operationalCost" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Kewajiban kendaraan</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.oneUnit.installment" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Komponen pengelolaan</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.oneUnit.managementComponent" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Proyeksi hasil mitra</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.oneUnit.projectedOwnerResult" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                </ul>
            </div>

            <div class="ca-multiple-units__scenario">
                <span class="ca-multiple-units__label ca-label">Skala Pengembangan</span>
                <h3 class="ca-multiple-units__unit ca-page-title">5 Unit</h3>

                <span class="ca-multiple-units__estimate-badge">
                    <span class="ca-multiple-units__estimate-icon" data-lucide="calculator" aria-hidden="true"></span>
                    Estimasi Linear — Bukan Angka Resmi
                </span>

                <ul class="ca-multiple-units__rows ca-list-reset">
                    <li>
                        <span class="ca-simulation-label">Hasil operasional bruto</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.fiveUnits.grossOperationalResult" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Biaya operasional</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.fiveUnits.operationalCost" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Kewajiban kendaraan</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.fiveUnits.installment" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Komponen pengelolaan</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.fiveUnits.managementComponent" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Proyeksi hasil mitra</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.fiveUnits.projectedOwnerResult" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                </ul>
            </div>

            <div class="ca-multiple-units__scenario">
                <span class="ca-multiple-units__label ca-label">Skala Armada</span>
                <h3 class="ca-multiple-units__unit ca-page-title">10 Unit</h3>

                <span class="ca-multiple-units__estimate-badge">
                    <span class="ca-multiple-units__estimate-icon" data-lucide="calculator" aria-hidden="true"></span>
                    Estimasi Linear — Bukan Angka Resmi
                </span>

                <ul class="ca-multiple-units__rows ca-list-reset">
                    <li>
                        <span class="ca-simulation-label">Hasil operasional bruto</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.tenUnits.grossOperationalResult" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Biaya operasional</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.tenUnits.operationalCost" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Kewajiban kendaraan</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.tenUnits.installment" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Komponen pengelolaan</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.tenUnits.managementComponent" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                    <li>
                        <span class="ca-simulation-label">Proyeksi hasil mitra</span>
                        <span class="ca-simulation-value is-pending" data-simulation-field="scenarios.tenUnits.projectedOwnerResult" data-simulation-format="currency">Menunggu angka final klien</span>
                    </li>
                </ul>
            </div>
        </div>

        <p class="ca-multiple-units__warning ca-simulation-note ca-simulation-note--dark">
            Nilai pada skala 5 dan 10 unit dihitung secara linear dari simulasi
            1 unit (dikalikan sesuai jumlah unit) semata-mata untuk memberi
            gambaran kasar skala operasional — <strong>bukan angka resmi</strong>
            yang dikonfirmasi terpisah oleh perusahaan. Struktur biaya,
            kebutuhan operasional, pembiayaan, dan pengelolaan pada skala yang
            lebih besar dapat berbeda dari hasil kali sederhana ini.
        </p>

        <div class="ca-multiple-units__cta">
            <x-button href="{{ route('about-contact') }}#contact" variant="primary" size="md">
                Minta Simulasi Berdasarkan Skala Unit
            </x-button>
        </div>
    </div>
</section>
