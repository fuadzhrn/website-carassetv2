{{-- SECTION 2 — Pentingnya Penghasilan Tambahan --}}
<section id="peluang-penghasilan" class="ca-income">
    <div class="ca-container ca-income__inner" data-reveal>
        <div class="ca-income__content">
            <x-section-heading
                :eyebrow="$data['eyebrow']"
                :title="$data['title']"
            />

            @if ($data['narrative_paragraphs'])
                <div class="ca-income__narrative">
                    @foreach ($data['narrative_paragraphs'] as $paragraph)
                        <p class="ca-body">{{ $paragraph }}</p>
                    @endforeach
                </div>
            @endif

            @if ($data['editorial_lines'])
                <div class="ca-income__panel">
                    <p class="ca-body">
                        @foreach ($data['editorial_lines'] as $line)
                            {{ $line }}@if (! $loop->last)<br>@endif
                        @endforeach
                    </p>
                </div>
            @endif

            @if ($data['cta'])
                <a href="{{ $data['cta']['url'] }}" target="{{ $data['cta']['target'] }}" class="ca-income__cta ca-nav-text">
                    {{ $data['cta']['label'] }}
                    <span class="ca-income__cta-icon" data-lucide="arrow-up-right" aria-hidden="true"></span>
                </a>
            @endif
        </div>

        <div class="ca-income__visual">
            <span class="ca-income__bg-text" aria-hidden="true">ASET PRODUKTIF</span>
            @if ($data['image']['url'])
                <img
                    src="{{ $data['image']['url'] }}"
                    alt="{{ $data['image']['alt'] }}"
                    width="1400"
                    height="933"
                    loading="lazy"
                    decoding="async"
                    class="ca-income__image"
                >
            @endif
        </div>
    </div>
</section>
