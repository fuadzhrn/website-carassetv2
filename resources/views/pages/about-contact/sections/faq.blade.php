{{-- SECTION 4 — FAQ Utama (Editorial FAQ Index) --}}
<section id="faq" class="ca-faq">
    <div class="ca-container ca-faq__inner">
        <div class="ca-faq__heading">
            @if ($data['eyebrow'])
                <span class="ca-faq__eyebrow ca-eyebrow">{{ $data['eyebrow'] }}</span>
            @endif
            <h2 class="ca-faq__title ca-section-title">{{ $data['title'] }}</h2>
            @if ($data['description'])
                <p class="ca-faq__description ca-body">
                    {{ $data['description'] }}
                </p>
            @endif
        </div>

        <div class="ca-faq__list" data-accordion>
            @foreach ($data['items'] as $index => $item)
                @php $number = $index + 1; @endphp
                <div class="ca-faq__item">
                    <span class="ca-faq__number" aria-hidden="true">{{ str_pad($number, 2, '0', STR_PAD_LEFT) }}</span>
                    <div class="ca-faq__body">
                        <h3 class="ca-faq__heading-item">
                            <button
                                type="button"
                                class="ca-faq__trigger"
                                aria-expanded="true"
                                aria-controls="ca-faq-panel-{{ $number }}"
                                id="ca-faq-trigger-{{ $number }}"
                                data-accordion-trigger
                            >
                                <span class="ca-faq__trigger-text">{{ $item['question'] }}</span>
                                <span class="ca-faq__icon" data-lucide="chevron-down" aria-hidden="true"></span>
                            </button>
                        </h3>
                        <div id="ca-faq-panel-{{ $number }}" class="ca-faq__panel" role="region" aria-labelledby="ca-faq-trigger-{{ $number }}" data-accordion-panel>
                            <p class="ca-body">
                                {{ $item['answer'] }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($data['closing_note'])
            <p class="ca-faq__closing-note ca-body-sm">
                {{ $data['closing_note'] }}
            </p>
        @endif
    </div>
</section>
