{{-- SECTION 1 — Tentang CarAsset (Editorial Brand Manifesto) --}}
<section id="tentang-carasset" class="ca-about" aria-labelledby="ca-about-heading">
    <div class="ca-container">
        <div class="ca-about__intro">
            <span class="ca-about__eyebrow ca-eyebrow">Tentang CarAsset</span>
            <h1 id="ca-about-heading" class="ca-about__title ca-page-title">
                Menghubungkan Kepemilikan Kendaraan dengan Pengelolaan yang Produktif.
            </h1>
        </div>

        <div class="ca-about__body">
            <div class="ca-about__narrative">
                <p class="ca-body-lg">
                    CarAsset adalah platform kemitraan kepemilikan kendaraan produktif
                    yang menghubungkan mitra, kendaraan, dan pengelolaan operasional
                    dalam satu ekosistem.
                </p>
                <p class="ca-body">
                    Melalui pendekatan Own–Operate–Grow, CarAsset membantu mitra
                    memahami proses kepemilikan, pengelolaan kendaraan, monitoring
                    operasional, serta peluang pengembangan aset secara bertahap
                    sesuai ketentuan program.
                </p>

                <blockquote class="ca-about__positioning">
                    Bukan sekadar memiliki kendaraan.<br>
                    CarAsset membantu membuat aset tetap bekerja.
                </blockquote>

                <div class="ca-about__actions ca-cluster">
                    <x-button href="{{ route('partnership') }}" variant="primary" size="md">
                        Kenali Program Kemitraan
                    </x-button>
                    <x-button href="#contact" variant="ghost" size="md">
                        Konsultasi Sekarang
                    </x-button>
                </div>
            </div>

            <div class="ca-about__tagline" aria-hidden="true">
                <span>Mobil</span>
                <span>Bekerja.</span>
                <span class="ca-about__tagline-accent">Aset</span>
                <span class="ca-about__tagline-accent">Bertumbuh.</span>
            </div>
        </div>

        <figure class="ca-about__strip">
            <img
                src="{{ asset('assets/images/about-contact/about-carasset.webp') }}"
                alt=""
                width="1200"
                height="800"
                loading="lazy"
                decoding="async"
                class="ca-about__strip-image"
            >
        </figure>
    </div>
</section>
