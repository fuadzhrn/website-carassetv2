{{-- SECTION 1 — Tentang CarAsset (Editorial Brand Manifesto) --}}
<section id="tentang-carasset" class="ca-about" aria-labelledby="ca-about-heading">
    <div class="ca-container">
        <div class="ca-about__intro">
            @if ($data['eyebrow'])
                <span class="ca-about__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif
            <h1 id="ca-about-heading" class="ca-about__title ca-page-title">
                {{ $data['title'] }}
            </h1>
        </div>

        <div class="ca-about__body">
            <div class="ca-about__narrative">
                @foreach ($data['narrative_paragraphs'] as $index => $paragraph)
                    <p class="{{ $index === 0 ? 'ca-body-lg' : 'ca-body' }}">
                        {{ $paragraph }}
                    </p>
                @endforeach

                @if ($data['positioning_lines'])
                    <blockquote class="ca-about__positioning">
                        {!! implode('<br>', array_map('e', $data['positioning_lines'])) !!}
                    </blockquote>
                @endif

                <div class="ca-about__actions ca-cluster">
                    @if ($data['primary_cta'])
                        <x-button href="{{ $data['primary_cta']['url'] }}" target="{{ $data['primary_cta']['target'] }}" variant="primary" size="md">
                            {{ $data['primary_cta']['label'] }}
                        </x-button>
                    @endif
                    @if ($data['secondary_cta'])
                        <x-button href="{{ $data['secondary_cta']['url'] }}" target="{{ $data['secondary_cta']['target'] }}" variant="ghost" size="md">
                            {{ $data['secondary_cta']['label'] }}
                        </x-button>
                    @endif
                </div>
            </div>

            @php
                $taglineWords = array_values(array_filter(explode(' ', (string) $data['tagline'])));
                $taglineAccentFrom = (int) ceil(count($taglineWords) / 2);
            @endphp
            @if ($taglineWords)
                <div class="ca-about__tagline" aria-hidden="true">
                    @foreach ($taglineWords as $wordIndex => $word)
                        <span class="{{ $wordIndex >= $taglineAccentFrom ? 'ca-about__tagline-accent' : '' }}">{{ $word }}</span>
                    @endforeach
                </div>
            @endif
        </div>

        <figure class="ca-about__strip">
            <img
                src="{{ $data['image']['url'] }}"
                alt="{{ $data['image']['alt'] }}"
                width="1200"
                height="800"
                loading="lazy"
                decoding="async"
                class="ca-about__strip-image"
            >
        </figure>
    </div>
</section>
