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
            <svg class="ca-hero__route" viewBox="0 0 1000 260" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                <path class="ca-hero__route-path" d="M 20 220 C 260 220, 300 60, 500 130 C 700 200, 740 40, 980 30" />
                <circle class="ca-hero__route-dot ca-hero__route-dot--green" cx="345" cy="112" r="6" />
                <circle class="ca-hero__route-dot ca-hero__route-dot--gold" cx="742" cy="45" r="6" />
            </svg>

            <div class="ca-hero__mark" aria-hidden="true">
                <span class="ca-hero__mark-ring ca-hero__mark-ring--outer"></span>
                <span class="ca-hero__mark-ring ca-hero__mark-ring--inner"></span>
                <span class="ca-hero__mark-core">
                    <span class="ca-hero__mark-icon" data-lucide="car-front" aria-hidden="true"></span>
                </span>
            </div>
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
