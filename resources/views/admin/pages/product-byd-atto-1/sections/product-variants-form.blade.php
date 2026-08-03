@php
    $variantLimit = $limits['variants'] ?? 5;
    $highlightLimit = $limits['variant_highlights'] ?? 8;
    $specLimit = $limits['variant_specs'] ?? 12;

    $currentFeaturedKey = collect($content['variants'] ?? [])
        ->first(fn ($variant) => ($variant['is_featured'] ?? false) === true)['item_key'] ?? null;
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

<x-admin::cms.data-status
    name-prefix="content"
    error-key-prefix="content"
    status-field-key="data_status"
    :value="$content['data_status'] ?? 'draft'"
    legend="Status Data Varian"
    :status-note="$content['status_note'] ?? ''"
/>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Daftar Varian (maks. {{ $variantLimit }}, urutan dapat diubah)</legend>
    <p class="ca-admin-field__helper">
        Pilih paling banyak satu varian sebagai "Unggulan" — dikendalikan oleh satu grup radio agar tidak mungkin lebih dari satu.
    </p>

    @for ($i = 0; $i < $variantLimit; $i++)
        @php
            $variant = $content['variants'][$i] ?? [];
            $variantItemKey = $variant['item_key'] ?? 'variant-'.($i + 1);
        @endphp
        <div class="ca-admin-repeater-row ca-admin-variant-panel" data-repeater-row>
            <input type="hidden" name="content[variants][{{ $i }}][item_key]" value="{{ $variantItemKey }}">

            <div class="ca-admin-repeater-row__controls">
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="up" {{ $i === 0 ? 'disabled' : '' }} aria-label="Naikkan urutan varian ini">
                    <span data-lucide="arrow-up" aria-hidden="true"></span>
                </button>
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="down" {{ $i === $variantLimit - 1 ? 'disabled' : '' }} aria-label="Turunkan urutan varian ini">
                    <span data-lucide="arrow-down" aria-hidden="true"></span>
                </button>
            </div>

            <label class="ca-admin-variant-panel__featured">
                <input type="radio" name="content[featured_variant]" value="{{ $variantItemKey }}" @checked($currentFeaturedKey === $variantItemKey)>
                Jadikan varian unggulan (featured)
            </label>

            <x-admin::form.field :name="'content.variants.'.$i.'.name'" label="Nama Varian">
                <x-admin::form.input :name="'content[variants]['.$i.'][name]'" :error-key="'content.variants.'.$i.'.name'" :value="$variant['name'] ?? ''" maxlength="100" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.variants.'.$i.'.subtitle'" label="Subjudul">
                <x-admin::form.input :name="'content[variants]['.$i.'][subtitle]'" :error-key="'content.variants.'.$i.'.subtitle'" :value="$variant['subtitle'] ?? ''" maxlength="180" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.variants.'.$i.'.description'" label="Deskripsi Varian">
                <x-admin::form.textarea :name="'content[variants]['.$i.'][description]'" :error-key="'content.variants.'.$i.'.description'" :value="$variant['description'] ?? ''" maxlength="700" rows="2" />
            </x-admin::form.field>

            <x-admin::media-picker
                :name="'content[variants]['.$i.'][image_media_id]'"
                label="Gambar Varian"
                :selected-media="$mediaById->get($variant['image_media_id'] ?? null)"
                :media-items="$recentMedia"
            />

            <x-admin::form.field :name="'content.variants.'.$i.'.image_alt'" label="Alt Text Gambar">
                <x-admin::form.input :name="'content[variants]['.$i.'][image_alt]'" :error-key="'content.variants.'.$i.'.image_alt'" :value="$variant['image_alt'] ?? ''" maxlength="255" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.variants.'.$i.'.badge'" label="Badge (opsional)">
                <x-admin::form.input :name="'content[variants]['.$i.'][badge]'" :error-key="'content.variants.'.$i.'.badge'" :value="$variant['badge'] ?? ''" maxlength="60" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.variants.'.$i.'.information_status'" label="Status Informasi Varian">
                <x-admin::form.select
                    :name="'content[variants]['.$i.'][information_status]'"
                    :error-key="'content.variants.'.$i.'.information_status'"
                    :options="['draft' => 'Menunggu Konfirmasi', 'confirmed' => 'Telah Dikonfirmasi']"
                    :selected="$variant['information_status'] ?? 'draft'"
                />
            </x-admin::form.field>

            <fieldset class="ca-admin-repeater-group ca-admin-nested-repeater" data-repeater-group>
                <legend class="ca-admin-cta-fields__legend">Highlight Varian (maks. {{ $highlightLimit }}, kosongkan slot yang tidak dipakai)</legend>
                @for ($h = 0; $h < $highlightLimit; $h++)
                    @php $highlight = $variant['highlights'][$h] ?? []; @endphp
                    <div class="ca-admin-nested-repeater-row">
                        <input type="hidden" name="content[variants][{{ $i }}][highlights][{{ $h }}][item_key]" value="{{ $highlight['item_key'] ?? 'highlight-'.($h + 1) }}">
                        <x-admin::form.field :name="'content.variants.'.$i.'.highlights.'.$h.'.label'" label="Label">
                            <x-admin::form.input :name="'content[variants]['.$i.'][highlights]['.$h.'][label]'" :error-key="'content.variants.'.$i.'.highlights.'.$h.'.label'" :value="$highlight['label'] ?? ''" maxlength="100" />
                        </x-admin::form.field>
                        <x-admin::form.field :name="'content.variants.'.$i.'.highlights.'.$h.'.value'" label="Value">
                            <x-admin::form.input :name="'content[variants]['.$i.'][highlights]['.$h.'][value]'" :error-key="'content.variants.'.$i.'.highlights.'.$h.'.value'" :value="$highlight['value'] ?? ''" maxlength="150" />
                        </x-admin::form.field>
                    </div>
                @endfor
            </fieldset>

            <fieldset class="ca-admin-repeater-group ca-admin-nested-repeater" data-repeater-group>
                <legend class="ca-admin-cta-fields__legend">Spesifikasi Varian (maks. {{ $specLimit }}, kosongkan slot yang tidak dipakai)</legend>
                @for ($s = 0; $s < $specLimit; $s++)
                    @php $spec = $variant['specifications'][$s] ?? []; @endphp
                    <div class="ca-admin-nested-repeater-row">
                        <input type="hidden" name="content[variants][{{ $i }}][specifications][{{ $s }}][item_key]" value="{{ $spec['item_key'] ?? 'spec-'.($s + 1) }}">
                        <x-admin::form.field :name="'content.variants.'.$i.'.specifications.'.$s.'.label'" label="Label">
                            <x-admin::form.input :name="'content[variants]['.$i.'][specifications]['.$s.'][label]'" :error-key="'content.variants.'.$i.'.specifications.'.$s.'.label'" :value="$spec['label'] ?? ''" maxlength="120" />
                        </x-admin::form.field>
                        <x-admin::form.field :name="'content.variants.'.$i.'.specifications.'.$s.'.value'" label="Value">
                            <x-admin::form.input :name="'content[variants]['.$i.'][specifications]['.$s.'][value]'" :error-key="'content.variants.'.$i.'.specifications.'.$s.'.value'" :value="$spec['value'] ?? ''" maxlength="150" />
                        </x-admin::form.field>
                        <x-admin::form.field :name="'content.variants.'.$i.'.specifications.'.$s.'.unit'" label="Unit (opsional)">
                            <x-admin::form.input :name="'content[variants]['.$i.'][specifications]['.$s.'][unit]'" :error-key="'content.variants.'.$i.'.specifications.'.$s.'.unit'" :value="$spec['unit'] ?? ''" maxlength="30" />
                        </x-admin::form.field>
                    </div>
                @endfor
            </fieldset>

            <x-admin::form.checkbox
                :name="'content[variants]['.$i.'][is_active]'"
                :error-key="'content.variants.'.$i.'.is_active'"
                value="1"
                :checked="(bool) ($variant['is_active'] ?? false)"
                label="Tampilkan varian ini"
            />
        </div>
    @endfor
</fieldset>
