{{-- SECTION 1 — Product Stage Hero (vertikal, terpusat — bukan split kiri-kanan).
     Gaya visual disamakan dengan pola yang sudah dipakai di halaman lain:
     eyebrow beraksen garis emas (section-heading.css), foto sebagai kartu
     berbayang lembut dengan badge mengambang (pola Business/OWN). --}}
<section id="product-hero" class="ca-product-hero">
    <div class="ca-container ca-product-hero__inner">
        @if ($data['eyebrow'])
            <span class="ca-product-hero__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
        @endif

        @if ($data['model_name'])
            <span class="ca-product-hero__model ca-label">{{ $data['model_name'] }}</span>
        @endif

        <h1 class="ca-product-hero__title ca-page-title">{{ $data['title'] }}</h1>

        @if ($data['tagline'])
            <p class="ca-product-hero__tagline ca-body-lg">{{ $data['tagline'] }}</p>
        @endif

        @if ($data['description'])
            <p class="ca-product-hero__description ca-body">{{ $data['description'] }}</p>
        @endif

        <div class="ca-product-hero__actions ca-cluster">
            @if ($data['primary_cta'])
                <x-button href="{{ $data['primary_cta']['url'] }}" target="{{ $data['primary_cta']['target'] }}" variant="primary" size="lg">
                    {{ $data['primary_cta']['label'] }}
                </x-button>
            @endif
            @if ($data['secondary_cta'])
                <x-button href="{{ $data['secondary_cta']['url'] }}" target="{{ $data['secondary_cta']['target'] }}" variant="outline" size="lg">
                    {{ $data['secondary_cta']['label'] }}
                </x-button>
            @endif
        </div>

        @if ($data['badges'])
            <ul class="ca-product-hero__badges ca-list-reset">
                @foreach ($data['badges'] as $badge)
                    <li class="ca-product-hero__badge">{{ $badge['label'] }}</li>
                @endforeach
            </ul>
        @endif

        <div class="ca-product-hero__stage">
            @if ($data['image']['url'])
                <img
                    src="{{ $data['image']['url'] }}"
                    alt="{{ $data['image']['alt'] }}"
                    width="1200"
                    height="800"
                    fetchpriority="high"
                    decoding="async"
                    class="ca-product-hero__image"
                >
            @endif

            @if ($data['microcopy'])
                <span class="ca-product-hero__badge-floating">
                    <span class="ca-product-hero__badge-icon" data-lucide="info" aria-hidden="true"></span>
                    <span>{{ $data['microcopy'] }}</span>
                </span>
            @endif
        </div>
    </div>
</section>
