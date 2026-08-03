{{-- SECTION 3 — Varian BYD ATTO 1 --}}
<section id="product-variants" class="ca-product-variants">
    <div class="ca-container">
        <x-section-heading
            :eyebrow="$data['eyebrow']"
            :title="$data['title']"
            :description="$data['description']"
        />

        <div class="ca-product-variants__grid ca-product-variants__grid--count-{{ min(count($data['variants']), 3) }}">
            @foreach ($data['variants'] as $variant)
                <article class="ca-product-variants__card {{ $variant['is_featured'] ? 'ca-product-variants__card--featured' : '' }}">
                    @if ($variant['is_featured'])
                        <span class="ca-product-variants__featured-badge">Unggulan</span>
                    @endif

                    @if ($variant['image']['url'])
                        <img
                            src="{{ $variant['image']['url'] }}"
                            alt="{{ $variant['image']['alt'] }}"
                            width="800"
                            height="600"
                            loading="lazy"
                            decoding="async"
                            class="ca-product-variants__image"
                        >
                    @endif

                    <div class="ca-product-variants__body">
                        @if ($variant['badge'])
                            <span class="ca-product-variants__badge ca-label">{{ $variant['badge'] }}</span>
                        @endif

                        <h3 class="ca-product-variants__name ca-card-title">{{ $variant['name'] }}</h3>

                        @if ($variant['subtitle'])
                            <p class="ca-product-variants__subtitle ca-body-sm">{{ $variant['subtitle'] }}</p>
                        @endif

                        @if ($variant['description'])
                            <p class="ca-product-variants__description ca-body">{{ $variant['description'] }}</p>
                        @endif

                        @if ($variant['highlights'])
                            <ul class="ca-product-variants__highlights ca-list-reset">
                                @foreach ($variant['highlights'] as $highlight)
                                    <li>
                                        <span class="ca-product-variants__highlight-label">{{ $highlight['label'] }}</span>
                                        @if ($highlight['value'] ?? null)
                                            <span class="ca-product-variants__highlight-value">{{ $highlight['value'] }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if ($variant['specifications'])
                            <dl class="ca-product-variants__specs">
                                @foreach ($variant['specifications'] as $spec)
                                    <div class="ca-product-variants__spec-row">
                                        <dt>{{ $spec['label'] }}</dt>
                                        <dd>{{ $spec['value'] }}{{ ($spec['unit'] ?? null) ? ' '.$spec['unit'] : '' }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
