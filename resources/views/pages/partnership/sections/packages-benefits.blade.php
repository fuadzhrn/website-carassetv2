{{-- SECTION 4 — Paket & Benefit (Progressive Partnership Scale) --}}
<section id="paket-kemitraan" class="ca-packages">
    <div class="ca-container">
        <x-section-heading
            align="center"
            title="Pilih Skala Kemitraan yang Sesuai dengan Rencana Anda."
            description="Mulai dari satu unit atau kembangkan skala kepemilikan sesuai kebutuhan, kemampuan, proses verifikasi, dan ketentuan program."
        />

        <div class="ca-packages__scale">
            <div class="ca-packages__package ca-packages__package--1">
                <span class="ca-packages__label ca-label">Langkah Awal</span>
                <h3 class="ca-packages__unit ca-display">1 Unit</h3>
                <p class="ca-packages__description ca-body-sm">
                    Untuk mitra yang ingin memulai dari satu aset dan memahami
                    sistem pengelolaan CarAsset.
                </p>
                <ul class="ca-packages__benefits ca-list-reset">
                    <li>Memulai dari satu unit</li>
                    <li>Mengenal sistem operasional</li>
                    <li>Mendapatkan informasi monitoring sesuai program</li>
                </ul>
                <x-button href="{{ route('about-contact') }}#contact" variant="outline" size="md" data-program="1-unit">
                    Konsultasi 1 Unit
                </x-button>
            </div>

            {{-- Status paket unggulan (Gold) bersifat sementara untuk prototipe.
                 Penetapan paket unggulan yang sesungguhnya WAJIB dikonfirmasi
                 kepada klien sebelum production. --}}
            <div class="ca-packages__package ca-packages__package--5">
                <span class="ca-packages__badge">Pilihan Pengembangan</span>
                <span class="ca-packages__label ca-label">Pengembangan Portofolio</span>
                <h3 class="ca-packages__unit ca-display">5 Unit</h3>
                <p class="ca-packages__description ca-body-sm">
                    Untuk mitra yang ingin membangun skala kepemilikan lebih luas
                    secara bertahap.
                </p>
                <ul class="ca-packages__benefits ca-list-reset">
                    <li>Pengelolaan beberapa unit</li>
                    <li>Dukungan koordinasi operasional</li>
                    <li>Perencanaan pengembangan kepemilikan</li>
                </ul>
                <x-button href="{{ route('about-contact') }}#contact" variant="gold" size="md" data-program="5-unit">
                    Konsultasi 5 Unit
                </x-button>
            </div>

            <div class="ca-packages__package ca-packages__package--10">
                <span class="ca-packages__label ca-label ca-packages__label--inverse">Skala Armada</span>
                <h3 class="ca-packages__unit ca-display ca-packages__unit--inverse">10 Unit</h3>
                <p class="ca-packages__description ca-body-sm ca-packages__description--inverse">
                    Untuk mitra yang ingin merencanakan pengelolaan kendaraan dalam
                    skala yang lebih besar.
                </p>
                <ul class="ca-packages__benefits ca-packages__benefits--inverse ca-list-reset">
                    <li>Pendekatan skala armada</li>
                    <li>Koordinasi program lebih luas</li>
                    <li>Konsultasi struktur kepemilikan dan operasional</li>
                </ul>
                <x-button href="{{ route('about-contact') }}#contact" variant="secondary" size="md" data-program="10-unit">
                    Konsultasi 10 Unit
                </x-button>
            </div>
        </div>

        <div class="ca-packages__footnote">
            <span class="ca-packages__footnote-badge">Benefit Menunggu Konfirmasi</span>
            <p class="ca-body-sm">
                Benefit tambahan mengikuti periode dan ketentuan program yang berlaku.
            </p>
        </div>
    </div>
</section>
