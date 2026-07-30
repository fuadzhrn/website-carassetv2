{{-- SECTION 5 — Alur Bisnis CarAsset --}}
<section id="alur-bisnis" class="ca-business-flow">
    <div class="ca-container">
        <x-section-heading
            align="center"
            eyebrow="Alur Bisnis CarAsset"
            title="Dari Konsultasi hingga Aset Mulai Dikelola."
            description="Setiap proses dilakukan secara bertahap agar calon mitra memahami program, dokumen, peran, serta mekanisme operasional sebelum kendaraan mulai dikelola."
        />

        <div class="ca-business-flow__timeline">
            <div class="ca-business-flow__track" aria-hidden="true"></div>

            <div class="ca-business-flow__step ca-business-flow__step--1">
                <span class="ca-business-flow__number" aria-hidden="true">01</span>
                <span class="ca-business-flow__icon" data-lucide="messages-square" aria-hidden="true"></span>
                <h3 class="ca-business-flow__title ca-card-title">Konsultasi Awal</h3>
                <p class="ca-business-flow__description ca-body-sm">
                    Calon mitra mempelajari program, pilihan kemitraan, dan gambaran
                    operasional bersama tim CarAsset.
                </p>
            </div>

            <div class="ca-business-flow__step ca-business-flow__step--2">
                <span class="ca-business-flow__number" aria-hidden="true">02</span>
                <span class="ca-business-flow__icon" data-lucide="clipboard-check" aria-hidden="true"></span>
                <h3 class="ca-business-flow__title ca-card-title">Verifikasi Data</h3>
                <p class="ca-business-flow__description ca-body-sm">
                    Dokumen dan kelayakan calon mitra diperiksa sesuai proses
                    pembiayaan dan ketentuan program.
                </p>
            </div>

            <div class="ca-business-flow__step ca-business-flow__step--3">
                <span class="ca-business-flow__number" aria-hidden="true">03</span>
                <span class="ca-business-flow__icon" data-lucide="car-front" aria-hidden="true"></span>
                <h3 class="ca-business-flow__title ca-card-title">Pengadaan Unit</h3>
                <p class="ca-business-flow__description ca-body-sm">
                    Proses pengadaan dan persiapan kendaraan dilakukan setelah
                    persyaratan dan ketentuan program disetujui.
                </p>
            </div>

            <div class="ca-business-flow__step ca-business-flow__step--4">
                <span class="ca-business-flow__number" aria-hidden="true">04</span>
                <span class="ca-business-flow__icon" data-lucide="route" aria-hidden="true"></span>
                <h3 class="ca-business-flow__title ca-card-title">Unit Mulai Dikelola</h3>
                <p class="ca-business-flow__description ca-body-sm">
                    Kendaraan dipersiapkan untuk operasional sesuai sistem
                    pengelolaan CarAsset dan mitra operasional terkait.
                </p>
            </div>

            <div class="ca-business-flow__step ca-business-flow__step--5">
                <span class="ca-business-flow__number" aria-hidden="true">05</span>
                <span class="ca-business-flow__icon" data-lucide="activity" aria-hidden="true"></span>
                <h3 class="ca-business-flow__title ca-card-title">Monitoring dan Laporan</h3>
                <p class="ca-business-flow__description ca-body-sm">
                    Mitra memperoleh informasi operasional sesuai sistem pelaporan
                    dan ketentuan yang diberlakukan.
                </p>
            </div>
        </div>

        <div class="ca-business-flow__footer">
            <div class="ca-business-flow__actions ca-cluster">
                <x-button href="{{ route('partnership') }}" variant="primary" size="md">
                    Pilih Program Kemitraan
                </x-button>
                <x-button href="{{ route('about-contact') }}#contact" variant="outline" size="md">
                    Konsultasi Sekarang
                </x-button>
            </div>

            <p class="ca-business-flow__microcopy ca-body-sm">
                Detail tahapan, persyaratan, dan waktu proses mengikuti hasil
                konsultasi serta ketentuan program yang berlaku.
            </p>
        </div>
    </div>
</section>
