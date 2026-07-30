{{-- SECTION 4 — Perlindungan & Monitoring Aset (Protection Layers & Monitoring Command View) --}}
<section id="perlindungan-monitoring" class="ca-protection">
    <div class="ca-container">
        <x-section-heading
            eyebrow="Perlindungan Aset"
            title="Aset Produktif Memerlukan Perlindungan dan Monitoring yang Terstruktur."
            description="CarAsset merancang pengelolaan kendaraan dengan memperhatikan perlindungan, kondisi kendaraan, aktivitas operasional, perawatan, dan informasi pelaporan sesuai ketentuan program."
        />

        <div class="ca-protection__layout">
            <div class="ca-protection__orbit">
                <span class="ca-protection__orbit-ring ca-protection__orbit-ring--outer" aria-hidden="true"></span>
                <span class="ca-protection__orbit-ring ca-protection__orbit-ring--inner" aria-hidden="true"></span>

                <div class="ca-protection__core">
                    <img
                        src="{{ asset('assets/images/simulation/protection-monitoring.webp') }}"
                        alt=""
                        width="1600"
                        height="1065"
                        loading="lazy"
                        decoding="async"
                        class="ca-protection__core-image"
                    >
                </div>

                <div class="ca-protection__point ca-protection__point--1">
                    <span class="ca-protection__point-icon" data-lucide="shield-check" aria-hidden="true"></span>
                    <span class="ca-protection__point-label ca-label">Asuransi Kendaraan</span>
                </div>
                <div class="ca-protection__point ca-protection__point--2">
                    <span class="ca-protection__point-icon" data-lucide="badge-check" aria-hidden="true"></span>
                    <span class="ca-protection__point-label ca-label">Garansi Kendaraan</span>
                </div>
                <div class="ca-protection__point ca-protection__point--3">
                    <span class="ca-protection__point-icon" data-lucide="map-pin" aria-hidden="true"></span>
                    <span class="ca-protection__point-label ca-label">GPS / Pelacakan</span>
                </div>
                <div class="ca-protection__point ca-protection__point--4">
                    <span class="ca-protection__point-icon" data-lucide="activity" aria-hidden="true"></span>
                    <span class="ca-protection__point-label ca-label">Monitoring Operasional</span>
                </div>
                <div class="ca-protection__point ca-protection__point--5">
                    <span class="ca-protection__point-icon" data-lucide="wrench" aria-hidden="true"></span>
                    <span class="ca-protection__point-label ca-label">Perawatan Berkala</span>
                </div>
                <div class="ca-protection__point ca-protection__point--6">
                    <span class="ca-protection__point-icon" data-lucide="file-chart-column" aria-hidden="true"></span>
                    <span class="ca-protection__point-label ca-label">Laporan Operasional</span>
                </div>
            </div>

            <p class="ca-protection__orbit-caption ca-caption">Ilustrasi Lapisan Perlindungan Aset</p>

            <div class="ca-protection__monitoring ca-simulation-panel" data-monitoring-panel>
                <div class="ca-protection__monitoring-header">
                    <span class="ca-protection__monitoring-title ca-card-title">Ilustrasi Sistem Tracking dan Monitoring</span>
                </div>

                <div class="ca-protection__tabs" role="tablist" aria-label="Kategori monitoring ilustratif">
                    <button type="button" class="ca-protection__tab" data-monitoring-tab="unit" aria-pressed="true">
                        Status Unit
                    </button>
                    <button type="button" class="ca-protection__tab" data-monitoring-tab="lokasi" aria-pressed="false">
                        Lokasi
                    </button>
                    <button type="button" class="ca-protection__tab" data-monitoring-tab="perawatan" aria-pressed="false">
                        Perawatan
                    </button>
                    <button type="button" class="ca-protection__tab" data-monitoring-tab="perlindungan" aria-pressed="false">
                        Perlindungan
                    </button>
                    <button type="button" class="ca-protection__tab" data-monitoring-tab="laporan" aria-pressed="false">
                        Laporan
                    </button>
                </div>

                <div class="ca-protection__panels">
                    <div class="ca-protection__panel-row" data-monitoring-content="unit">
                        <span class="ca-simulation-label">Status Unit</span>
                        <span class="ca-simulation-value is-final">Contoh Status</span>
                    </div>
                    <div class="ca-protection__panel-row" data-monitoring-content="lokasi">
                        <span class="ca-simulation-label">Lokasi</span>
                        <span class="ca-simulation-value is-final">Informasi Lokasi</span>
                    </div>
                    <div class="ca-protection__panel-row" data-monitoring-content="perawatan">
                        <span class="ca-simulation-label">Perawatan</span>
                        <span class="ca-simulation-value is-final">Jadwal Perawatan</span>
                    </div>
                    <div class="ca-protection__panel-row" data-monitoring-content="perlindungan">
                        <span class="ca-simulation-label">Perlindungan</span>
                        <span class="ca-simulation-value is-final">Status Perlindungan</span>
                    </div>
                    <div class="ca-protection__panel-row" data-monitoring-content="laporan">
                        <span class="ca-simulation-label">Laporan</span>
                        <span class="ca-simulation-value is-final">Ringkasan Operasional</span>
                    </div>
                </div>

                <p class="ca-protection__monitoring-note ca-simulation-note">
                    Tampilan merupakan ilustrasi konsep. Sistem dan informasi final
                    mengikuti fitur serta proses operasional yang dikonfirmasi
                    perusahaan.
                </p>
            </div>
        </div>
    </div>
</section>
