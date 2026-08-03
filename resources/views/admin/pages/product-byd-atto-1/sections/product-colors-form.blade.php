@php
    $galleryLimit = $limits['gallery'] ?? 8;
@endphp

<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="700" rows="2" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Galeri Kendaraan (maks. {{ $galleryLimit }}, urutan dapat diubah)</legend>
    <p class="ca-admin-field__helper">
        Galeri boleh memakai visual sementara (ilustrasi generik kendaraan listrik) selama ditandai "Gambar sementara" — gambar ini bukan foto resmi BYD ATTO 1.
    </p>

    @for ($i = 0; $i < $galleryLimit; $i++)
        @php $item = $content['gallery'][$i] ?? []; @endphp
        <div class="ca-admin-repeater-row" data-repeater-row>
            <input type="hidden" name="content[gallery][{{ $i }}][item_key]" value="{{ $item['item_key'] ?? 'gallery-'.($i + 1) }}">

            <div class="ca-admin-repeater-row__controls">
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="up" {{ $i === 0 ? 'disabled' : '' }} aria-label="Naikkan urutan galeri ini">
                    <span data-lucide="arrow-up" aria-hidden="true"></span>
                </button>
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="down" {{ $i === $galleryLimit - 1 ? 'disabled' : '' }} aria-label="Turunkan urutan galeri ini">
                    <span data-lucide="arrow-down" aria-hidden="true"></span>
                </button>
            </div>

            <x-admin::media-picker
                :name="'content[gallery]['.$i.'][media_id]'"
                label="Gambar Galeri"
                :selected-media="$mediaById->get($item['media_id'] ?? null)"
                :media-items="$recentMedia"
            />

            <x-admin::form.field :name="'content.gallery.'.$i.'.alt'" label="Alt Text">
                <x-admin::form.input :name="'content[gallery]['.$i.'][alt]'" :error-key="'content.gallery.'.$i.'.alt'" :value="$item['alt'] ?? ''" maxlength="255" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.gallery.'.$i.'.view_label'" label="Label Tampilan (mis. Tampak Depan)">
                <x-admin::form.input :name="'content[gallery]['.$i.'][view_label]'" :error-key="'content.gallery.'.$i.'.view_label'" :value="$item['view_label'] ?? ''" maxlength="100" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.gallery.'.$i.'.caption'" label="Caption (opsional)">
                <x-admin::form.input :name="'content[gallery]['.$i.'][caption]'" :error-key="'content.gallery.'.$i.'.caption'" :value="$item['caption'] ?? ''" maxlength="300" />
            </x-admin::form.field>

            <x-admin::form.checkbox
                :name="'content[gallery]['.$i.'][is_temporary]'"
                :error-key="'content.gallery.'.$i.'.is_temporary'"
                value="1"
                :checked="(bool) ($item['is_temporary'] ?? true)"
                label="Gambar sementara (bukan aset resmi)"
            />

            <x-admin::form.checkbox
                :name="'content[gallery]['.$i.'][is_active]'"
                :error-key="'content.gallery.'.$i.'.is_active'"
                value="1"
                :checked="(bool) ($item['is_active'] ?? false)"
                label="Tampilkan gambar ini"
            />
        </div>
    @endfor
</fieldset>

<x-admin::form.field name="content.gallery_note" label="Catatan Galeri">
    <x-admin::form.textarea name="content[gallery_note]" error-key="content.gallery_note" :value="$content['gallery_note'] ?? ''" maxlength="500" rows="2" />
</x-admin::form.field>
