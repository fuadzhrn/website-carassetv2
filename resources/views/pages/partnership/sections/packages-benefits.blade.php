{{-- SECTION 4 — Paket & Benefit (Progressive Partnership Scale) --}}
<section id="paket-kemitraan" class="ca-packages">
    <div class="ca-container">
        <x-section-heading
            align="center"
            :title="$data['title']"
            :description="$data['description']"
        />

        @php
            // Class modifier --1/--5/--10 mengikuti unit_count (struktur
            // terkunci, tidak bisa diubah admin). Variant tombol dasar per
            // paket dipertahankan seperti desain asli; status "unggulan"
            // (badge + tombol gold) mengikuti featured_package yang dipilih
            // admin, bukan lagi terkunci ke paket 5 Unit — status gold
            // bersifat sementara untuk prototipe, WAJIB dikonfirmasi klien
            // sebelum production.
            $baseVariants = ['one_unit' => 'outline', 'five_units' => 'secondary', 'ten_units' => 'secondary'];
            $dataProgramAttr = ['one_unit' => '1-unit', 'five_units' => '5-unit', 'ten_units' => '10-unit'];
        @endphp

        <div class="ca-packages__scale">
            @foreach ($data['packages'] as $packageKey => $package)
                <div class="ca-packages__package ca-packages__package--{{ $package['unit_count'] }}">
                    @if ($package['is_featured'])
                        <span class="ca-packages__badge">Pilihan Pengembangan</span>
                    @endif

                    <span class="ca-packages__label ca-label{{ $packageKey === 'ten_units' ? ' ca-packages__label--inverse' : '' }}">{{ $package['label'] }}</span>
                    <h3 class="ca-packages__unit ca-display{{ $packageKey === 'ten_units' ? ' ca-packages__unit--inverse' : '' }}">{{ $package['title'] }}</h3>
                    <p class="ca-packages__description ca-body-sm{{ $packageKey === 'ten_units' ? ' ca-packages__description--inverse' : '' }}">
                        {{ $package['description'] }}
                    </p>
                    <ul class="ca-packages__benefits ca-list-reset{{ $packageKey === 'ten_units' ? ' ca-packages__benefits--inverse' : '' }}">
                        @foreach ($package['benefits'] as $benefit)
                            <li>{{ $benefit['text'] }}</li>
                        @endforeach
                    </ul>
                    @if ($package['cta'])
                        <x-button
                            href="{{ $package['cta']['url'] }}"
                            target="{{ $package['cta']['target'] }}"
                            variant="{{ $package['is_featured'] ? 'gold' : $baseVariants[$packageKey] }}"
                            size="md"
                            data-program="{{ $dataProgramAttr[$packageKey] }}"
                        >
                            {{ $package['cta']['label'] }}
                        </x-button>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="ca-packages__footnote">
            <span class="ca-packages__footnote-badge">Benefit Menunggu Konfirmasi</span>
            <p class="ca-body-sm">
                {{ $data['disclaimer'] }}
            </p>
        </div>
    </div>
</section>
