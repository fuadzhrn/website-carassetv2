{{-- SECTION 5 — Kontak & Form Konsultasi (Consultation Workspace) --}}
<section id="contact" class="ca-contact">
    <div class="ca-container ca-contact__layout">
        <div class="ca-contact__form-area">
            <x-section-heading
                :title="$data['title']"
                :description="$data['description']"
            />

            <div class="ca-contact__form-status">
                <span class="ca-contact__form-status-icon" data-lucide="info" aria-hidden="true"></span>
                Form Konsultasi — Tampilan Front-end
            </div>

            @if (session('success'))
                <div class="ca-contact__form-message is-success" role="status" aria-live="polite" data-contact-status>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('contact_error') || $errors->has('form'))
                <div class="ca-contact__form-message is-error" role="alert" data-contact-status>
                    {{ session('contact_error') ?? $errors->first('form') }}
                </div>
            @endif

            <form class="ca-contact__form" method="POST" action="{{ route('consultation.store') }}" data-contact-form novalidate>
                @csrf

                <x-form-field
                    label="Nama Lengkap"
                    name="name"
                    id="contact-name"
                    required
                    autocomplete="name"
                    placeholder="Masukkan nama lengkap"
                    :value="old('name')"
                    :error="$errors->first('name')"
                />

                <x-form-field
                    label="Nomor WhatsApp"
                    name="whatsapp"
                    id="contact-whatsapp"
                    type="tel"
                    required
                    autocomplete="tel"
                    inputmode="tel"
                    placeholder="Contoh: 0812xxxxxxx"
                    :value="old('whatsapp')"
                    :error="$errors->first('whatsapp')"
                />

                <x-form-field
                    label="Email"
                    name="email"
                    id="contact-email"
                    type="email"
                    autocomplete="email"
                    placeholder="nama@email.com"
                    :value="old('email')"
                    :error="$errors->first('email')"
                />

                <x-form-field
                    label="Program yang Diminati"
                    name="program"
                    id="contact-program"
                    type="select"
                    required
                    :value="old('program', '')"
                    :error="$errors->first('program')"
                    :options="['' => 'Pilih program'] + collect($data['form']['program_options'])->pluck('label', 'value')->all()"
                />

                <x-form-field
                    label="Pesan atau Kebutuhan Konsultasi"
                    name="message"
                    id="contact-message"
                    type="textarea"
                    required
                    rows="6"
                    placeholder="Tuliskan pertanyaan atau rencana yang ingin dikonsultasikan"
                    :value="old('message')"
                    :error="$errors->first('message')"
                    data-message-counter
                />

                @if ($data['form']['consent_label'])
                    <x-form-field
                        type="checkbox"
                        name="consent"
                        id="contact-consent"
                        required
                        label="{{ $data['form']['consent_label'] }}"
                        :error="$errors->first('consent')"
                    />
                @endif

                {{-- Honeypot — kosong bagi pengunjung sungguhan, tidak boleh fokus/terbaca screen reader. --}}
                <div class="ca-visually-hidden" aria-hidden="true">
                    <label for="contact-website">Jangan diisi</label>
                    <input type="text" id="contact-website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <input type="hidden" name="form_token" value="{{ $data['form']['token'] }}">

                <x-button
                    type="submit"
                    variant="primary"
                    size="lg"
                    icon="send"
                    data-contact-submit
                    :disabled="! $data['form']['consent_label']"
                    :aria-disabled="! $data['form']['consent_label'] ? 'true' : 'false'"
                >
                    {{ $data['form']['submit_label'] ?? 'Siapkan Pesan Konsultasi' }}
                </x-button>

                @if ($data['form']['microcopy'])
                    <p class="ca-contact__form-note ca-body-sm">
                        {{ $data['form']['microcopy'] }}
                    </p>
                @endif
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
                <h3 class="ca-contact__info-title ca-card-title">{{ $data['contact_panel']['title'] ?? 'Informasi Kontak' }}</h3>

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

            @if ($data['map']['is_available'])
                <div class="ca-contact-map">
                    <iframe
                        class="ca-contact-map__iframe"
                        src="{{ $data['map']['embed_url'] }}"
                        loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"
                        title="{{ $data['map']['title'] ?? 'Lokasi kantor CarAsset' }}"
                    ></iframe>
                </div>
            @endif
        </div>
    </div>
</section>
