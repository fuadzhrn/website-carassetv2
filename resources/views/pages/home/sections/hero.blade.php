{{-- SECTION 1 — Hero & Value Proposition --}}
<section class="ca-hero" aria-labelledby="ca-hero-heading">
    <div class="ca-hero__route" aria-hidden="true">
        <span class="ca-hero__route-dot ca-hero__route-dot--green"></span>
        <span class="ca-hero__route-dot ca-hero__route-dot--gold"></span>
    </div>

    <div class="ca-container ca-hero__inner">
        <div class="ca-hero__content">
            <span class="ca-hero__eyebrow ca-eyebrow">Platform Aset Kendaraan Produktif</span>

            <h1 id="ca-hero-heading" class="ca-hero__title ca-display">
                Mobil Bekerja.<br>
                Aset Bertumbuh.
            </h1>

            <p class="ca-hero__lead ca-body-lg">Miliki Asetnya. Biarkan Mobilnya Bekerja.</p>

            <p class="ca-hero__description ca-body">
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

        <div class="ca-hero__visual">
            <div class="ca-hero__image-frame">
                <img
                    src="{{ asset('assets/images/home/hero-electric-car.webp') }}"
                    alt="Kendaraan listrik CarAsset yang dikelola sebagai aset produktif"
                    width="1800"
                    height="2700"
                    class="ca-hero__image"
                >
            </div>

            <div class="ca-hero__panels">
                <div class="ca-hero__panel">
                    <span class="ca-hero__panel-icon" data-lucide="badge-check" aria-hidden="true"></span>
                    <span class="ca-hero__panel-label ca-label">Aset Milik Mitra</span>
                </div>
                <div class="ca-hero__panel">
                    <span class="ca-hero__panel-icon" data-lucide="settings" aria-hidden="true"></span>
                    <span class="ca-hero__panel-label ca-label">Dikelola Profesional</span>
                </div>
                <div class="ca-hero__panel">
                    <span class="ca-hero__panel-icon" data-lucide="activity" aria-hidden="true"></span>
                    <span class="ca-hero__panel-label ca-label">Monitoring Transparan</span>
                </div>
            </div>
        </div>
    </div>
</section>
