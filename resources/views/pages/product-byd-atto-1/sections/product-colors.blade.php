{{-- SECTION 2 — Product Gallery. Foto kendaraan sebagai kartu berbayang
     lembut + badge mengambang, memakai bahasa visual yang sama dengan pola
     foto di halaman lain (Business/OWN). Kolom tunggal, dipusatkan —
     bukan lagi layout dua kolom foto+pilihan warna. --}}
<section id="product-colors" class="ca-product-colors">
    <div class="ca-container">
        <x-section-heading
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        <div class="ca-product-colors__visual">
            <div class="ca-product-gallery" data-product-gallery>
                <div class="ca-product-gallery__stage">
                    <img
                        src="{{ $data['gallery'][0]['image']['url'] ?? '' }}"
                        alt="{{ $data['gallery'][0]['image']['alt'] ?? '' }}"
                        width="1000"
                        height="700"
                        decoding="async"
                        class="ca-product-gallery__stage-image"
                        data-product-gallery-image
                    >

                    @if ($data['gallery'][0]['is_temporary'] ?? false)
                        <span class="ca-product-gallery__badge-floating" data-product-gallery-status>Visual Sementara</span>
                    @else
                        <span class="ca-product-gallery__badge-floating" data-product-gallery-status hidden></span>
                    @endif
                </div>

                <p class="ca-product-gallery__caption" data-product-gallery-caption>
                    {{ $data['gallery'][0]['caption'] ?? ($data['gallery'][0]['view_label'] ?? '') }}
                </p>

                <div class="ca-product-gallery__thumbs" role="list" aria-label="Pilih tampilan gambar kendaraan">
                    @foreach ($data['gallery'] as $index => $item)
                        <button
                            type="button"
                            class="ca-product-gallery__thumb {{ $index === 0 ? 'is-active' : '' }}"
                            data-product-gallery-thumb
                            data-image="{{ $item['image']['url'] }}"
                            data-alt="{{ $item['image']['alt'] }}"
                            data-caption="{{ $item['caption'] ?? ($item['view_label'] ?? '') }}"
                            data-temporary="{{ $item['is_temporary'] ? '1' : '0' }}"
                            aria-pressed="{{ $index === 0 ? 'true' : 'false' }}"
                        >
                            <img src="{{ $item['image']['url'] }}" alt="" loading="lazy" width="140" height="98">
                            @if ($item['view_label'])
                                <span class="ca-product-gallery__thumb-label">{{ $item['view_label'] }}</span>
                            @endif
                        </button>
                    @endforeach
                </div>

                @if ($data['gallery_note'])
                    <p class="ca-product-gallery__note ca-body-sm">{{ $data['gallery_note'] }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
