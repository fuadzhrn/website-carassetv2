{{--
    Read-only audit of every image the page's sections currently
    reference (see PageImageSeoService). Never edits alt text here — it
    only links to the section editor (or Media Library) where alt text
    actually lives, so there is never a second, duplicated alt-text
    source.
--}}
@props(['rows'])

@php
    $sourceLabels = [
        'section' => 'Section',
        'media_library' => 'Media Library',
        'fallback' => 'Fallback',
        'kosong' => 'Kosong',
    ];
@endphp

<div class="ca-admin-seo-alt-audit">
    @if (empty($rows))
        <p class="ca-admin-seo-alt-audit__empty">Halaman ini tidak memiliki gambar yang terdeteksi pada section-nya.</p>
    @else
        <ul class="ca-admin-seo-alt-audit__list">
            @foreach ($rows as $row)
                <li class="ca-admin-seo-alt-audit__item">
                    <div class="ca-admin-seo-alt-audit__thumb">
                        @if ($row['thumbnail_url'])
                            <img src="{{ $row['thumbnail_url'] }}" alt="" width="64" height="64" loading="lazy">
                        @else
                            <span class="ca-admin-seo-alt-audit__thumb-placeholder" data-lucide="image-off" aria-hidden="true"></span>
                        @endif
                    </div>

                    <div class="ca-admin-seo-alt-audit__info">
                        <p class="ca-admin-seo-alt-audit__section">{{ $row['section_label'] }}</p>
                        <p class="ca-admin-seo-alt-audit__name">
                            @if ($row['media_name'])
                                {{ $row['media_name'] }}
                            @elseif ($row['media_id'])
                                Media tidak ditemukan (ID {{ $row['media_id'] }})
                            @else
                                Menggunakan gambar bawaan sistem — belum ada gambar diunggah
                            @endif
                        </p>
                        <p class="ca-admin-seo-alt-audit__alt">
                            {{ $row['alt_effective'] ?: '(kosong)' }}
                            <span class="ca-admin-seo-alt-audit__source">Sumber: {{ $sourceLabels[$row['alt_source']] ?? $row['alt_source'] }}</span>
                        </p>

                        @if ($row['status'] === 'perlu_ditinjau')
                            <p class="ca-admin-seo-alt-audit__helper">
                                Pastikan gambar ini memang dekoratif sebelum menggunakan alt kosong.
                            </p>
                        @endif
                    </div>

                    <div class="ca-admin-seo-alt-audit__status">
                        @if ($row['status'] === 'tersedia')
                            <x-admin::status-badge variant="active">Tersedia</x-admin::status-badge>
                        @else
                            <x-admin::status-badge variant="pending">Perlu Ditinjau</x-admin::status-badge>
                        @endif
                    </div>

                    <div class="ca-admin-seo-alt-audit__action">
                        <x-admin::button :href="$row['edit_url']" variant="ghost" size="sm" icon="pencil">
                            Edit
                        </x-admin::button>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
