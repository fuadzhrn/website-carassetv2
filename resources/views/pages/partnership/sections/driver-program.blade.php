{{-- SECTION 3 — Program Mitra Driver (Road to Ownership) --}}
<section id="mitra-driver" class="ca-driver-program">
    <div class="ca-container">
        <div class="ca-driver-program__intro">
            <div class="ca-driver-program__intro-content">
                <span class="ca-driver-program__eyebrow ca-eyebrow">Mitra Driver</span>

                <h2 class="ca-driver-program__title ca-section-title">
                    Jalankan Kendaraannya.<br>
                    Bangun Peluang Kepemilikannya.
                </h2>

                <p class="ca-driver-program__description ca-body">
                    Program Mitra Driver dirancang bagi driver yang ingin menjalankan
                    kendaraan secara produktif sambil mengikuti proses menuju
                    kepemilikan sesuai skema dan ketentuan program.
                </p>
            </div>

            <div class="ca-driver-program__intro-visual">
                <img
                    src="{{ asset('assets/images/partnership/driver-program.webp') }}"
                    alt="Driver profesional yang menjalankan kendaraan dalam program Mitra Driver CarAsset"
                    width="1600"
                    height="1068"
                    loading="lazy"
                    decoding="async"
                    class="ca-driver-program__image"
                >
            </div>
        </div>

        <div class="ca-driver-program__timeline" data-driver-journey>
            <div class="ca-driver-program__track" aria-hidden="true"></div>

            <div class="ca-driver-program__milestone" data-driver-milestone>
                <span class="ca-driver-program__milestone-dot" aria-hidden="true">
                    <span class="ca-driver-program__milestone-icon" data-lucide="user-check" aria-hidden="true"></span>
                </span>
                <span class="ca-driver-program__milestone-eyebrow ca-label">Tahap 1</span>
                <h3 class="ca-driver-program__milestone-title ca-card-title">Mulai sebagai Mitra Driver</h3>
                <p class="ca-driver-program__milestone-description ca-body-sm">
                    Calon driver mengikuti proses pendaftaran, pemeriksaan, dan
                    persiapan sesuai ketentuan program.
                </p>
            </div>

            <div class="ca-driver-program__milestone" data-driver-milestone>
                <span class="ca-driver-program__milestone-dot" aria-hidden="true">
                    <span class="ca-driver-program__milestone-icon" data-lucide="car-front" aria-hidden="true"></span>
                </span>
                <span class="ca-driver-program__milestone-eyebrow ca-label">Tahap 2</span>
                <h3 class="ca-driver-program__milestone-title ca-card-title">Menjalankan Operasional Kendaraan</h3>
                <p class="ca-driver-program__milestone-description ca-body-sm">
                    Driver menjalankan kendaraan sesuai sistem operasional dan
                    standar yang ditetapkan.
                </p>
            </div>

            <div class="ca-driver-program__milestone" data-driver-milestone>
                <span class="ca-driver-program__milestone-dot" aria-hidden="true">
                    <span class="ca-driver-program__milestone-icon" data-lucide="wallet-cards" aria-hidden="true"></span>
                </span>
                <span class="ca-driver-program__milestone-eyebrow ca-label">Tahap 3</span>
                <h3 class="ca-driver-program__milestone-title ca-card-title">Kontribusi Kepemilikan</h3>
                <p class="ca-driver-program__milestone-description ca-body-sm">
                    Komponen operasional dan kontribusi kepemilikan mengikuti skema
                    yang disepakati dalam program.
                </p>
            </div>

            <div class="ca-driver-program__milestone" data-driver-milestone>
                <span class="ca-driver-program__milestone-dot" aria-hidden="true">
                    <span class="ca-driver-program__milestone-icon" data-lucide="clipboard-check" aria-hidden="true"></span>
                </span>
                <span class="ca-driver-program__milestone-eyebrow ca-label">Tahap 4</span>
                <h3 class="ca-driver-program__milestone-title ca-card-title">Pemenuhan Ketentuan Program</h3>
                <p class="ca-driver-program__milestone-description ca-body-sm">
                    Proses kepemilikan berjalan sesuai pemenuhan kewajiban, evaluasi,
                    dan ketentuan yang berlaku.
                </p>
            </div>

            <div class="ca-driver-program__milestone" data-driver-milestone>
                <span class="ca-driver-program__milestone-dot ca-driver-program__milestone-dot--gold" aria-hidden="true">
                    <span class="ca-driver-program__milestone-icon" data-lucide="key-round" aria-hidden="true"></span>
                </span>
                <span class="ca-driver-program__milestone-eyebrow ca-label">Tahap 5</span>
                <h3 class="ca-driver-program__milestone-title ca-card-title">Menuju Kepemilikan Unit</h3>
                <p class="ca-driver-program__milestone-description ca-body-sm">
                    Setelah seluruh persyaratan program terpenuhi, proses kepemilikan
                    mengikuti dokumen dan ketentuan final yang disepakati.
                </p>
            </div>
        </div>

        <div class="ca-driver-program__after">
            <h3 class="ca-driver-program__after-title ca-card-title">Setelah Unit Dimiliki</h3>
            <p class="ca-driver-program__after-lead ca-body-sm">
                Setelah unit dimiliki, mitra driver dapat mempertimbangkan:
            </p>
            <ul class="ca-driver-program__after-list ca-list-reset">
                <li>Mengoperasikan unit sendiri</li>
                <li>Mengikuti sistem pengelolaan CarAsset</li>
                <li>Mengembangkan peluang sumber penghasilan sesuai kondisi program</li>
            </ul>
        </div>

        <div class="ca-driver-program__cta">
            <x-button href="{{ route('about-contact') }}#contact" variant="primary" size="md">
                Konsultasikan Program Driver
            </x-button>
            <p class="ca-driver-program__note ca-disclaimer-text">
                Skema kontribusi, periode, dan proses kepemilikan menunggu data
                final serta ketentuan resmi perusahaan.
            </p>
        </div>
    </div>
</section>
