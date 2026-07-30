{{-- SECTION 2 — Program Mitra Owner (Ownership Architecture) --}}
<section id="mitra-owner" class="ca-owner-program">
    <div class="ca-container">
        <x-section-heading
            align="center"
            eyebrow="Mitra Owner"
            title="Miliki Asetnya. Operasionalnya Kami Kelola."
            description="Program Mitra Owner ditujukan bagi calon mitra yang ingin memiliki kendaraan dan mempercayakan pengelolaan operasionalnya kepada CarAsset sesuai ketentuan program."
        />

        <div class="ca-owner-program__stage">
            <div class="ca-owner-program__frame">
                <img
                    src="{{ asset('assets/images/partnership/owner-program.webp') }}"
                    alt="Calon mitra owner dengan kendaraan listrik yang akan dikelola sebagai aset produktif"
                    width="1600"
                    height="1067"
                    loading="lazy"
                    decoding="async"
                    class="ca-owner-program__image"
                >
            </div>

            <div class="ca-owner-program__callout ca-owner-program__callout--tl">
                <span class="ca-owner-program__callout-icon" data-lucide="key-round" aria-hidden="true"></span>
                <span class="ca-owner-program__callout-label ca-label">Aset Milik Mitra</span>
            </div>
            <div class="ca-owner-program__callout ca-owner-program__callout--tr">
                <span class="ca-owner-program__callout-icon" data-lucide="settings" aria-hidden="true"></span>
                <span class="ca-owner-program__callout-label ca-label">Operasional Dikelola</span>
            </div>
            <div class="ca-owner-program__callout ca-owner-program__callout--bl">
                <span class="ca-owner-program__callout-icon" data-lucide="activity" aria-hidden="true"></span>
                <span class="ca-owner-program__callout-label ca-label">Monitoring dan Laporan</span>
            </div>
            <div class="ca-owner-program__callout ca-owner-program__callout--br">
                <span class="ca-owner-program__callout-icon" data-lucide="wrench" aria-hidden="true"></span>
                <span class="ca-owner-program__callout-label ca-label">Perawatan Sesuai Program</span>
            </div>
        </div>

        <p class="ca-owner-program__stage-caption ca-caption">Visualisasi Struktur Program Mitra Owner</p>

        <div class="ca-owner-program__roles">
            <div class="ca-owner-program__role">
                <h3 class="ca-owner-program__role-title ca-card-title">
                    <span class="ca-owner-program__role-icon" data-lucide="user" aria-hidden="true"></span>
                    Peran Mitra
                </h3>
                <ul class="ca-owner-program__role-list ca-list-reset">
                    <li>Menyiapkan dokumen yang dibutuhkan</li>
                    <li>Memilih program sesuai kebutuhan</li>
                    <li>Menjalani proses verifikasi</li>
                    <li>Memiliki aset sesuai ketentuan kerja sama</li>
                </ul>
            </div>

            <div class="ca-owner-program__role-divider" aria-hidden="true"></div>

            <div class="ca-owner-program__role">
                <h3 class="ca-owner-program__role-title ca-card-title">
                    <span class="ca-owner-program__role-icon" data-lucide="building-2" aria-hidden="true"></span>
                    Peran CarAsset
                </h3>
                <ul class="ca-owner-program__role-list ca-list-reset">
                    <li>Membantu proses persiapan program</li>
                    <li>Mengelola kebutuhan operasional</li>
                    <li>Mengelola driver sesuai sistem</li>
                    <li>Membantu monitoring dan pelaporan</li>
                </ul>
            </div>
        </div>

        <ul class="ca-owner-program__benefits ca-list-reset">
            <li class="ca-owner-program__benefit">
                <span class="ca-owner-program__benefit-icon" data-lucide="badge-check" aria-hidden="true"></span>
                <span class="ca-body-sm">Struktur kepemilikan yang jelas</span>
            </li>
            <li class="ca-owner-program__benefit">
                <span class="ca-owner-program__benefit-icon" data-lucide="badge-check" aria-hidden="true"></span>
                <span class="ca-body-sm">Pengelolaan operasional profesional</span>
            </li>
            <li class="ca-owner-program__benefit">
                <span class="ca-owner-program__benefit-icon" data-lucide="badge-check" aria-hidden="true"></span>
                <span class="ca-body-sm">Monitoring dan informasi operasional</span>
            </li>
        </ul>

        <div class="ca-owner-program__cta">
            <x-button href="{{ route('about-contact') }}#contact" variant="secondary" size="md">
                Konsultasikan Program Owner
            </x-button>
            <p class="ca-owner-program__microcopy ca-body-sm">
                Detail kepemilikan, pembiayaan, dan operasional mengikuti hasil
                verifikasi serta ketentuan program.
            </p>
        </div>
    </div>
</section>
