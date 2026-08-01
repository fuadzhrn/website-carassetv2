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

        @php
            $whatsapp = $siteSettings['contact.whatsapp'] ?? null;
            $whatsappUrl = $siteWhatsappUrl ?? null;
            $email = $siteSettings['contact.email'] ?? 'hello@carasset.id';
            $address = $siteSettings['contact.address']
                ?? "Gajah Mada Tower, Lt. 19-01, Jl. Gajah Mada No.19-26, RT.2/RW.1, Petojo Utara, Kecamatan Gambir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10130";
            $businessHours = $siteSettings['contact.business_hours'] ?? 'Senin–Jumat, 09.00–17.00';
        @endphp

        <div class="ca-contact__rail">
            <div class="ca-contact__info-panel">
                <h3 class="ca-contact__info-title ca-card-title">Informasi Kontak</h3>

                <ul class="ca-contact__info-list ca-list-reset">
                    @if ($whatsappUrl)
                        <li class="ca-contact__info-item">
                            <span class="ca-contact__info-icon" data-lucide="phone" aria-hidden="true"></span>
                            <div>
                                <span class="ca-contact__info-label">WhatsApp</span>
                                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="ca-contact__info-value ca-contact__info-value--filled">{{ $whatsapp }}</a>
                            </div>
                        </li>
                    @endif
                    @if ($email)
                        <li class="ca-contact__info-item">
                            <span class="ca-contact__info-icon" data-lucide="mail" aria-hidden="true"></span>
                            <div>
                                <span class="ca-contact__info-label">Email</span>
                                <a href="mailto:{{ $email }}" class="ca-contact__info-value ca-contact__info-value--filled">{{ $email }}</a>
                            </div>
                        </li>
                    @endif
                    @if ($address)
                        <li class="ca-contact__info-item">
                            <span class="ca-contact__info-icon" data-lucide="map-pin" aria-hidden="true"></span>
                            <div>
                                <span class="ca-contact__info-label">Head Office</span>
                                <span class="ca-contact__info-value ca-contact__info-value--filled ca-contact__info-value--address">
                                    {{ $address }}
                                </span>
                            </div>
                        </li>
                    @endif
                    @if ($businessHours)
                        <li class="ca-contact__info-item">
                            <span class="ca-contact__info-icon" data-lucide="clock-3" aria-hidden="true"></span>
                            <div>
                                <span class="ca-contact__info-label">Jam Layanan</span>
                                <span class="ca-contact__info-value ca-contact__info-value--filled">{{ $businessHours }}</span>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="ca-contact-map">
                <iframe
                    class="ca-contact-map__iframe"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3093.878843926693!2d106.81870909999999!3d-6.1607189!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5df4fccc6e7%3A0x66b6d7b7ea79dc8a!2sGajah%20Mada%20Plaza%20Mall!5e1!3m2!1sid!2sid!4v1785448057387!5m2!1sid!2sid"
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    title="Lokasi kantor CarAsset — Gajah Mada Tower"
                ></iframe>
            </div>
        </div>
    </div>
</section>
