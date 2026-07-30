{{-- SECTION 1 — Hero & Value Proposition (Cinematic Center-Stage) --}}
<section class="ca-hero ca-hero--center-stage" aria-labelledby="ca-hero-heading" data-hero-intro>
    <div class="ca-hero__glow" aria-hidden="true"></div>

    <div class="ca-container ca-hero__container">
        <div class="ca-hero__content" data-hero-part="content">
            <span class="ca-hero__eyebrow ca-eyebrow">Platform Aset Kendaraan Produktif</span>

            <h1 id="ca-hero-heading" class="ca-hero__title ca-display">
                Mobil Bekerja.<br>
                Aset <span class="ca-hero__title-accent">Bertumbuh.</span>
            </h1>

            <p class="ca-hero__subheadline">Miliki Asetnya. Biarkan Mobilnya Bekerja.</p>

            <p class="ca-hero__description ca-body-lg">
                CarAsset membantu mitra memiliki kendaraan produktif yang dikelola secara
                profesional untuk mendukung pertumbuhan aset secara bertahap dan transparan.
            </p>

            <div class="ca-hero__actions ca-cluster">
                <x-button href="{{ route('about-contact') }}#contact" variant="primary" size="lg">
                    Konsultasi Sekarang
                </x-button>
                <x-button href="#cara-kerja" variant="outline" size="lg">
                    Pelajari Cara Kerja
                </x-button>
            </div>
        </div>

        <div class="ca-hero__stage" data-hero-part="stage">
            <svg class="ca-hero__route" viewBox="0 0 1000 220" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                <path class="ca-hero__route-path" d="M 20 190 C 240 190, 300 40, 500 105 C 700 170, 780 30, 980 25" />
                <circle class="ca-hero__route-dot ca-hero__route-dot--green" cx="345" cy="90" r="6" />
                <circle class="ca-hero__route-dot ca-hero__route-dot--gold" cx="760" cy="65" r="6" />
            </svg>

            <img
                src="{{ asset('assets/images/home/hero-electric-car.webp') }}"
                alt="Kendaraan listrik yang dikelola sebagai aset produktif CarAsset"
                width="2000"
                height="1150"
                fetchpriority="high"
                decoding="async"
                class="ca-hero__stage-image"
            >
        </div>

        <div class="ca-hero-status" data-hero-part="status">
            <div class="ca-hero-status__item">
                <span class="ca-hero-status__icon" data-lucide="badge-check" aria-hidden="true"></span>
                <span class="ca-hero-status__label ca-label">Aset Milik Mitra</span>
            </div>
            <span class="ca-hero-status__separator" aria-hidden="true"></span>
            <div class="ca-hero-status__item">
                <span class="ca-hero-status__icon" data-lucide="settings" aria-hidden="true"></span>
                <span class="ca-hero-status__label ca-label">Dikelola Profesional</span>
            </div>
            <span class="ca-hero-status__separator" aria-hidden="true"></span>
            <div class="ca-hero-status__item">
                <span class="ca-hero-status__icon" data-lucide="activity" aria-hidden="true"></span>
                <span class="ca-hero-status__label ca-label">Monitoring Transparan</span>
            </div>
        </div>
    </div>
</section>
