{{-- SECTION 5 — Kontak & Form Konsultasi (Consultation Workspace) --}}
<section id="contact" class="ca-contact">
    <div class="ca-container ca-contact__layout">
        <div class="ca-contact__form-area">
            <x-section-heading
                title="Mulai Percakapan tentang Aset Produktif Anda."
                description="Sampaikan program yang ingin dipelajari. Tim CarAsset akan membantu menjelaskan alur, dokumen, asumsi operasional, dan ketentuan program."
            />

            <div class="ca-contact__form-status">
                <span class="ca-contact__form-status-icon" data-lucide="info" aria-hidden="true"></span>
                Form Konsultasi — Tampilan Front-end
            </div>
            <p class="ca-contact__form-microcopy ca-body-sm">
                Form belum terhubung ke sistem pengiriman atau database.
            </p>

            {{--
                Form ini murni tampilan front-end. Integrasi backend/WhatsApp
                akan dikerjakan pada fase terpisah setelah sistem pengiriman
                resmi tersedia — lihat public/assets/js/pages/about-contact/contact-form.js
            --}}
            <form class="ca-contact__form" data-contact-form novalidate>
                <x-form-field
                    label="Nama Lengkap"
                    name="name"
                    id="contact-name"
                    required
                    autocomplete="name"
                    placeholder="Masukkan nama lengkap"
                />

                <x-form-field
                    label="Nomor WhatsApp"
                    name="whatsapp"
                    id="contact-whatsapp"
                    type="tel"
                    required
                    autocomplete="tel"
                    placeholder="Contoh: 0812xxxxxxx"
                />

                <x-form-field
                    label="Email — Opsional"
                    name="email"
                    id="contact-email"
                    type="email"
                    autocomplete="email"
                    placeholder="nama@email.com"
                />

                <x-form-field
                    label="Jenis Program"
                    name="program"
                    id="contact-program"
                    type="select"
                    required
                    :value="''"
                    :options="[
                        '' => 'Pilih program',
                        'mitra-owner' => 'Mitra Owner',
                        'mitra-driver' => 'Mitra Driver',
                        'simulasi-1-unit' => 'Simulasi 1 Unit',
                        'simulasi-5-unit' => 'Simulasi 5 Unit',
                        'simulasi-10-unit' => 'Simulasi 10 Unit',
                        'konsultasi-umum' => 'Konsultasi Umum',
                    ]"
                />

                <x-form-field
                    label="Pesan"
                    name="message"
                    id="contact-message"
                    type="textarea"
                    required
                    rows="6"
                    placeholder="Tuliskan pertanyaan atau rencana yang ingin dikonsultasikan"
                />

                <x-form-field
                    type="checkbox"
                    name="consent"
                    id="contact-consent"
                    required
                    label="Saya memahami bahwa informasi awal pada website merupakan ilustrasi dan detail final mengikuti konsultasi serta ketentuan program."
                />

                <div class="ca-contact__form-message" role="status" aria-live="polite" data-contact-status></div>

                <x-button type="submit" variant="primary" size="lg" icon="send">
                    Siapkan Pesan Konsultasi
                </x-button>

                <p class="ca-contact__form-note ca-body-sm">
                    Form versi prototipe. Pengiriman belum aktif.
                </p>
            </form>
        </div>

        <div class="ca-contact__rail">
            <div class="ca-contact__info-panel">
                <h3 class="ca-contact__info-title ca-card-title">Informasi Kontak</h3>

                <ul class="ca-contact__info-list ca-list-reset">
                    <li class="ca-contact__info-item">
                        <span class="ca-contact__info-icon" data-lucide="phone" aria-hidden="true"></span>
                        <div>
                            <span class="ca-contact__info-label">WhatsApp</span>
                            <span class="ca-contact__info-value">Menunggu data resmi</span>
                        </div>
                    </li>
                    <li class="ca-contact__info-item">
                        <span class="ca-contact__info-icon" data-lucide="mail" aria-hidden="true"></span>
                        <div>
                            <span class="ca-contact__info-label">Email</span>
                            <span class="ca-contact__info-value">Menunggu data resmi</span>
                        </div>
                    </li>
                    <li class="ca-contact__info-item">
                        <span class="ca-contact__info-icon" data-lucide="map-pin" aria-hidden="true"></span>
                        <div>
                            <span class="ca-contact__info-label">Alamat</span>
                            <span class="ca-contact__info-value">Menunggu data resmi</span>
                        </div>
                    </li>
                    <li class="ca-contact__info-item">
                        <span class="ca-contact__info-icon" data-lucide="clock-3" aria-hidden="true"></span>
                        <div>
                            <span class="ca-contact__info-label">Jam Layanan</span>
                            <span class="ca-contact__info-value">Menunggu data resmi</span>
                        </div>
                    </li>
                </ul>

                <p class="ca-contact__info-note ca-body-sm">
                    Informasi kontak akan diperbarui sebelum publikasi.
                </p>
            </div>

            {{-- Ganti dengan embed peta resmi setelah alamat disetujui. --}}
            <div class="ca-contact-map-placeholder">
                <span class="ca-contact-map-placeholder__icon" data-lucide="map-pin" aria-hidden="true"></span>
                <p class="ca-contact-map-placeholder__text ca-body-sm">
                    Lokasi kantor akan ditampilkan setelah alamat resmi dikonfirmasi.
                </p>
            </div>
        </div>
    </div>
</section>
