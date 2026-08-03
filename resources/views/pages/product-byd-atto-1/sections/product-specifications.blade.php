{{-- SECTION 4 — Spesifikasi & Fitur BYD ATTO 1 --}}
<section id="product-specifications" class="ca-product-specifications">
    <div class="ca-container">
        <x-section-heading
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        @if ($data['specification_categories'])
            <div class="ca-product-specifications__categories">
                @foreach ($data['specification_categories'] as $category)
                    <div class="ca-product-specifications__category">
                        <h3 class="ca-product-specifications__category-title ca-card-title">{{ $category['title'] }}</h3>
                        @if ($category['description'])
                            <p class="ca-product-specifications__category-description ca-body-sm">{{ $category['description'] }}</p>
                        @endif

                        <dl class="ca-product-specifications__list">
                            @foreach ($category['items'] as $item)
                                <div class="ca-product-specifications__row">
                                    <dt>{{ $item['label'] }}</dt>
                                    <dd>{{ $item['value'] }}{{ ($item['unit'] ?? null) ? ' '.$item['unit'] : '' }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endforeach
            </div>
        @endif

        @if ($data['features'])
            <div class="ca-product-specifications__features">
                @foreach ($data['features'] as $feature)
                    <div class="ca-product-specifications__feature">
                        @if ($feature['image']['url'])
                            <img
                                src="{{ $feature['image']['url'] }}"
                                alt="{{ $feature['image']['alt'] }}"
                                width="400"
                                height="300"
                                loading="lazy"
                                decoding="async"
                                class="ca-product-specifications__feature-image"
                            >
                        @endif
                        <h4 class="ca-product-specifications__feature-title ca-card-title">{{ $feature['title'] }}</h4>
                        @if ($feature['description'])
                            <p class="ca-product-specifications__feature-description ca-body-sm">{{ $feature['description'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
