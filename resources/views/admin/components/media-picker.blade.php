@props([
    'name',
    'label' => null,
    'selectedMedia' => null,
    'mediaItems' => [],
    'required' => false,
    'helper' => null,
])

<div class="ca-admin-media-picker" data-media-picker>
    @if ($label)
        <span class="ca-admin-field__label">
            {{ $label }}
            @if ($required)
                <span aria-hidden="true">*</span>
                <span class="ca-admin-visually-hidden">(wajib diisi)</span>
            @endif
        </span>
    @endif

    <div class="ca-admin-media-picker__preview" data-media-picker-preview>
        @if ($selectedMedia && $selectedMedia->url())
            <img src="{{ $selectedMedia->url() }}" alt="{{ $selectedMedia->alt_text }}" data-media-picker-image>
            <span class="ca-admin-media-picker__alt" data-media-picker-alt>{{ $selectedMedia->alt_text }}</span>
        @else
            <span class="ca-admin-media-picker__empty" data-media-picker-empty>
                <span data-lucide="image" aria-hidden="true"></span>
                Belum ada gambar dipilih
            </span>
        @endif
    </div>

    <input type="hidden" name="{{ $name }}" value="{{ $selectedMedia?->id }}" data-media-picker-input>

    <div class="ca-admin-media-picker__actions">
        <x-admin::button type="button" variant="outline" size="sm" data-media-picker-open>
            Pilih Media
        </x-admin::button>
        <x-admin::button
            type="button"
            variant="ghost"
            size="sm"
            data-media-picker-clear
            :hidden="! $selectedMedia"
        >
            Hapus Pilihan
        </x-admin::button>
        <x-admin::button :href="route('admin.media.index')" target="_blank" variant="ghost" size="sm">
            Buka Media Library
        </x-admin::button>
    </div>

    @if ($helper)
        <p class="ca-admin-field__helper">{{ $helper }}</p>
    @endif

    <dialog class="ca-admin-modal ca-admin-modal--wide" data-media-picker-modal>
        <div class="ca-admin-modal__inner">
            <div class="ca-admin-modal__header">
                <h2 class="ca-admin-modal__title">Pilih Media</h2>
                <button type="button" class="ca-admin-modal__close" data-media-picker-close aria-label="Tutup pemilih media">
                    <span data-lucide="x" aria-hidden="true"></span>
                </button>
            </div>

            @if (count($mediaItems) === 0)
                <p class="ca-admin-section__description">
                    Belum ada media. <a href="{{ route('admin.media.create') }}">Upload media baru</a>.
                </p>
            @else
                <div class="ca-admin-media-picker__grid">
                    @foreach ($mediaItems as $item)
                        <button
                            type="button"
                            class="ca-admin-media-picker__item"
                            data-media-picker-item
                            data-media-id="{{ $item->id }}"
                            data-media-url="{{ $item->url() }}"
                            data-media-alt="{{ $item->alt_text }}"
                        >
                            @if ($item->url())
                                <img src="{{ $item->url() }}" alt="" loading="lazy">
                            @endif
                            <span>{{ $item->original_name }}</span>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </dialog>
</div>
