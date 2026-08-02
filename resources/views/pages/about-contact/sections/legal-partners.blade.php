{{-- SECTION 3 — Legalitas & Partner (Trust Registry) --}}
<section id="legalitas-partner" class="ca-legal">
    <div class="ca-container">
        <x-section-heading
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        @php
            $legal = $data['legal'];
            $isLegalReady = $legal['entity_name'] || $legal['registration_number'];
        @endphp

        <span class="ca-legal__status">
            <span class="ca-legal__status-icon" data-lucide="info" aria-hidden="true"></span>
            {{ $isLegalReady ? 'Data Legalitas Telah Dikonfirmasi' : 'Data Legalitas Menunggu Konfirmasi' }}
        </span>

        <div class="ca-legal__registry">
            <div class="ca-legal__area">
                <h3 class="ca-legal__area-title ca-card-title">Legalitas</h3>

                <dl class="ca-legal__list">
                    <div class="ca-legal__item">
                        <span class="ca-legal__item-icon" data-lucide="building-2" aria-hidden="true"></span>
                        <div>
                            <dt class="ca-legal__label">Nama Badan Usaha</dt>
                            <dd class="ca-legal__value{{ $legal['entity_name'] ? ' ca-legal__value--filled' : '' }}">
                                {{ $legal['entity_name'] ?: 'Menunggu data resmi perusahaan' }}
                            </dd>
                        </div>
                    </div>
                    <div class="ca-legal__item">
                        <span class="ca-legal__item-icon" data-lucide="file-check-2" aria-hidden="true"></span>
                        <div>
                            <dt class="ca-legal__label">Nomor Legalitas</dt>
                            <dd class="ca-legal__value{{ $legal['registration_number'] ? ' ca-legal__value--filled' : '' }}">
                                {{ $legal['registration_number'] ?: 'Menunggu data resmi perusahaan' }}
                            </dd>
                        </div>
                    </div>
                    <div class="ca-legal__item">
                        <span class="ca-legal__item-icon" data-lucide="map-pin" aria-hidden="true"></span>
                        <div>
                            <dt class="ca-legal__label">Alamat Terdaftar</dt>
                            <dd class="ca-legal__value{{ $legal['registered_address'] ? ' ca-legal__value--filled' : '' }}">
                                {{ $legal['registered_address'] ?: 'Menunggu data resmi perusahaan' }}
                            </dd>
                        </div>
                    </div>
                    <div class="ca-legal__item">
                        <span class="ca-legal__item-icon" data-lucide="badge-check" aria-hidden="true"></span>
                        <div>
                            <dt class="ca-legal__label">Dokumen Pendukung</dt>
                            @if ($legal['documents'])
                                <dd class="ca-legal__value ca-legal__value--filled">
                                    {{ collect($legal['documents'])->pluck('title')->implode(', ') }}
                                </dd>
                            @else
                                <dd class="ca-legal__value">Menunggu dokumen resmi perusahaan</dd>
                            @endif
                        </div>
                    </div>
                </dl>
            </div>

            <div class="ca-legal__divider" aria-hidden="true"></div>

            <div class="ca-legal__area">
                <h3 class="ca-legal__area-title ca-card-title">Partner Operasional</h3>

                <p class="ca-legal__partner-note ca-body-sm">
                    {{ $data['partner_note'] }}
                </p>

                <div class="ca-legal__partner-grid">
                    @forelse ($data['partners'] as $partner)
                        @php $partnerTag = ($partner['url'] ?? null) ? 'a' : 'div'; @endphp
                        <{{ $partnerTag }}
                            class="ca-legal__partner-placeholder"
                            @if ($partner['url'] ?? null)
                                href="{{ $partner['url'] }}"
                                @if ($partner['open_new_tab'] ?? true) target="_blank" rel="noopener noreferrer" @endif
                            @endif
                        >
                            @if ($partner['logo_url'] ?? null)
                                <img src="{{ $partner['logo_url'] }}" alt="{{ $partner['logo_alt'] }}" style="max-width:100%;max-height:100%;object-fit:contain;">
                            @else
                                {{ $partner['name'] }}
                            @endif
                        </{{ $partnerTag }}>
                    @empty
                        <div class="ca-legal__partner-placeholder">Logo Partner Resmi</div>
                        <div class="ca-legal__partner-placeholder">Logo Partner Resmi</div>
                        <div class="ca-legal__partner-placeholder">Logo Partner Resmi</div>
                        <div class="ca-legal__partner-placeholder">Logo Partner Resmi</div>
                    @endforelse
                </div>
            </div>
        </div>

        <p class="ca-legal__note ca-body-sm">
            Seluruh informasi pada bagian ini harus diperbarui menggunakan
            dokumen dan aset resmi sebelum website dipublikasikan.
        </p>
    </div>
</section>
