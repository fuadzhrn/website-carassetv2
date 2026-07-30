{{-- SECTION 4 — Pilihan Program Kemitraan --}}
<section class="ca-partnership-choice">
    <div class="ca-container">
        <x-section-heading
            align="center"
            eyebrow="Pilih Jalur Kemitraan"
            title="Satu Ekosistem, Dua Cara untuk Bertumbuh Bersama CarAsset."
            description="Pilih program yang paling sesuai dengan posisi dan tujuan Anda."
        />

        <div class="ca-partnership-choice__grid" data-reveal>
            <article class="ca-partnership-panel ca-partnership-panel--owner">
                <img
                    src="{{ asset('assets/images/home/owner-program.webp') }}"
                    alt="Konsultasi bisnis mengenai kepemilikan kendaraan sebagai aset"
                    width="1400"
                    height="2100"
                    loading="lazy"
                    decoding="async"
                    class="ca-partnership-panel__image"
                >
                <div class="ca-partnership-panel__overlay" aria-hidden="true"></div>

                <div class="ca-partnership-panel__content">
                    <span class="ca-partnership-panel__eyebrow ca-eyebrow">Untuk Pemilik Aset</span>
                    <h3 class="ca-partnership-panel__title ca-page-title">Mitra Owner</h3>
                    <p class="ca-partnership-panel__description ca-body">
                        Miliki kendaraan atas nama Anda dan percayakan pengelolaan
                        operasionalnya kepada CarAsset.
                    </p>

                    <ul class="ca-partnership-panel__benefits ca-list-reset">
                        <li>
                            <span class="ca-partnership-panel__benefit-icon" data-lucide="key-round" aria-hidden="true"></span>
                            Kepemilikan aset yang jelas
                        </li>
                        <li>
                            <span class="ca-partnership-panel__benefit-icon" data-lucide="settings" aria-hidden="true"></span>
                            Pengelolaan operasional profesional
                        </li>
                        <li>
                            <span class="ca-partnership-panel__benefit-icon" data-lucide="activity" aria-hidden="true"></span>
                            Monitoring dan laporan berkala
                        </li>
                    </ul>

                    <x-button href="{{ route('partnership') }}#mitra-owner" variant="gold" size="md">
                        Pelajari Mitra Owner
                    </x-button>
                </div>
            </article>

            <article class="ca-partnership-panel ca-partnership-panel--driver">
                <img
                    src="{{ asset('assets/images/home/driver-program.webp') }}"
                    alt="Driver profesional mengemudikan kendaraan CarAsset"
                    width="1400"
                    height="935"
                    loading="lazy"
                    decoding="async"
                    class="ca-partnership-panel__image"
                >
                <div class="ca-partnership-panel__overlay" aria-hidden="true"></div>

                <div class="ca-partnership-panel__content">
                    <span class="ca-partnership-panel__eyebrow ca-eyebrow">Untuk Driver</span>
                    <h3 class="ca-partnership-panel__title ca-page-title">Mitra Driver</h3>
                    <p class="ca-partnership-panel__description ca-body">
                        Jalankan kendaraan secara produktif sambil membangun peluang
                        menuju kepemilikan unit sesuai ketentuan program.
                    </p>

                    <ul class="ca-partnership-panel__benefits ca-list-reset">
                        <li>
                            <span class="ca-partnership-panel__benefit-icon" data-lucide="route" aria-hidden="true"></span>
                            Jalur bertahap menuju kepemilikan
                        </li>
                        <li>
                            <span class="ca-partnership-panel__benefit-icon" data-lucide="settings" aria-hidden="true"></span>
                            Dukungan ekosistem operasional
                        </li>
                        <li>
                            <span class="ca-partnership-panel__benefit-icon" data-lucide="trending-up" aria-hidden="true"></span>
                            Peluang membangun sumber penghasilan tambahan
                        </li>
                    </ul>

                    <x-button href="{{ route('partnership') }}#mitra-driver" variant="primary" size="md">
                        Pelajari Mitra Driver
                    </x-button>
                </div>
            </article>
        </div>
    </div>
</section>
