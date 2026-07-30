{{-- SECTION 5 — CTA Konsultasi --}}
<section id="konsultasi-home" class="ca-consultation">
    <div class="ca-consultation__route" aria-hidden="true"></div>

    <div class="ca-container ca-consultation__inner" data-reveal>
        <div class="ca-consultation__content">
            <x-section-heading
                theme="dark"
                eyebrow="Mulai Bersama CarAsset"
                title="Mulai dari Satu Unit. Bangun Aset Produktif Anda."
                description="Kenali cara kerja program, pilihan kemitraan, dan ilustrasi operasional bersama tim CarAsset sebelum mengambil keputusan."
            />

            <div class="ca-consultation__actions ca-cluster">
                <x-button href="{{ route('about-contact') }}#contact" variant="primary" size="lg">
                    Jadwalkan Konsultasi
                </x-button>
                <x-button href="{{ route('simulation') }}" variant="outline" size="lg">
                    Lihat Simulasi & Perlindungan
                </x-button>
            </div>

            <p class="ca-consultation__microcopy ca-body-sm">
                Konsultasi awal membantu Anda memahami program, proses, serta asumsi
                operasional yang digunakan.
            </p>
        </div>

        <ul class="ca-consultation__trust ca-list-reset">
            <li class="ca-consultation__trust-item">
                <span class="ca-consultation__trust-icon" data-lucide="badge-check" aria-hidden="true"></span>
                <span>Aset atas nama mitra</span>
            </li>
            <li class="ca-consultation__trust-item">
                <span class="ca-consultation__trust-icon" data-lucide="settings" aria-hidden="true"></span>
                <span>Pengelolaan profesional</span>
            </li>
            <li class="ca-consultation__trust-item">
                <span class="ca-consultation__trust-icon" data-lucide="activity" aria-hidden="true"></span>
                <span>Perlindungan dan perawatan</span>
            </li>
            <li class="ca-consultation__trust-item">
                <span class="ca-consultation__trust-icon" data-lucide="route" aria-hidden="true"></span>
                <span>Monitoring operasional</span>
            </li>
        </ul>
    </div>
</section>
