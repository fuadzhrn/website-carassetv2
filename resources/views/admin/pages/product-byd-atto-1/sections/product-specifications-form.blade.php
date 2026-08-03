@php
    $categoryLimit = $limits['spec_categories'] ?? 6;
    $itemLimit = $limits['spec_items_per_category'] ?? 10;
    $featureLimit = $limits['feature_items'] ?? 12;
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
    legend="Status Data Spesifikasi & Fitur"
    :status-note="$content['status_note'] ?? ''"
/>
<p class="ca-admin-field__helper">
    Galeri gambar kendaraan dikelola pada section "Galeri Kendaraan" (tidak diduplikasi di sini).
</p>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Kategori Spesifikasi (maks. {{ $categoryLimit }})</legend>

    @for ($c = 0; $c < $categoryLimit; $c++)
        @php $category = $content['specification_categories'][$c] ?? []; @endphp
        <div class="ca-admin-repeater-row ca-admin-spec-category" data-repeater-row>
            <input type="hidden" name="content[specification_categories][{{ $c }}][item_key]" value="{{ $category['item_key'] ?? 'spec-category-'.($c + 1) }}">

            <div class="ca-admin-repeater-row__controls">
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="up" {{ $c === 0 ? 'disabled' : '' }} aria-label="Naikkan urutan kategori ini">
                    <span data-lucide="arrow-up" aria-hidden="true"></span>
                </button>
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="down" {{ $c === $categoryLimit - 1 ? 'disabled' : '' }} aria-label="Turunkan urutan kategori ini">
                    <span data-lucide="arrow-down" aria-hidden="true"></span>
                </button>
            </div>

            <x-admin::form.field :name="'content.specification_categories.'.$c.'.title'" label="Judul Kategori">
                <x-admin::form.input :name="'content[specification_categories]['.$c.'][title]'" :error-key="'content.specification_categories.'.$c.'.title'" :value="$category['title'] ?? ''" maxlength="120" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.specification_categories.'.$c.'.description'" label="Deskripsi Kategori (opsional)">
                <x-admin::form.textarea :name="'content[specification_categories]['.$c.'][description]'" :error-key="'content.specification_categories.'.$c.'.description'" :value="$category['description'] ?? ''" maxlength="500" rows="2" />
            </x-admin::form.field>

            <fieldset class="ca-admin-repeater-group ca-admin-nested-repeater" data-repeater-group>
                <legend class="ca-admin-cta-fields__legend">Item Spesifikasi (maks. {{ $itemLimit }}, kosongkan slot yang tidak dipakai)</legend>
                @for ($it = 0; $it < $itemLimit; $it++)
                    @php $item = $category['items'][$it] ?? []; @endphp
                    <div class="ca-admin-nested-repeater-row">
                        <input type="hidden" name="content[specification_categories][{{ $c }}][items][{{ $it }}][item_key]" value="{{ $item['item_key'] ?? 'spec-item-'.($it + 1) }}">
                        <x-admin::form.field :name="'content.specification_categories.'.$c.'.items.'.$it.'.label'" label="Label">
                            <x-admin::form.input :name="'content[specification_categories]['.$c.'][items]['.$it.'][label]'" :error-key="'content.specification_categories.'.$c.'.items.'.$it.'.label'" :value="$item['label'] ?? ''" maxlength="120" />
                        </x-admin::form.field>
                        <x-admin::form.field :name="'content.specification_categories.'.$c.'.items.'.$it.'.value'" label="Value">
                            <x-admin::form.input :name="'content[specification_categories]['.$c.'][items]['.$it.'][value]'" :error-key="'content.specification_categories.'.$c.'.items.'.$it.'.value'" :value="$item['value'] ?? ''" maxlength="180" />
                        </x-admin::form.field>
                        <x-admin::form.field :name="'content.specification_categories.'.$c.'.items.'.$it.'.unit'" label="Unit (opsional)">
                            <x-admin::form.input :name="'content[specification_categories]['.$c.'][items]['.$it.'][unit]'" :error-key="'content.specification_categories.'.$c.'.items.'.$it.'.unit'" :value="$item['unit'] ?? ''" maxlength="30" />
                        </x-admin::form.field>
                    </div>
                @endfor
            </fieldset>

            <x-admin::form.checkbox
                :name="'content[specification_categories]['.$c.'][is_active]'"
                :error-key="'content.specification_categories.'.$c.'.is_active'"
                value="1"
                :checked="(bool) ($category['is_active'] ?? false)"
                label="Tampilkan kategori ini"
            />
        </div>
    @endfor
</fieldset>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Fitur (maks. {{ $featureLimit }})</legend>

    @for ($f = 0; $f < $featureLimit; $f++)
        @php $feature = $content['features'][$f] ?? []; @endphp
        <div class="ca-admin-repeater-row" data-repeater-row>
            <input type="hidden" name="content[features][{{ $f }}][item_key]" value="{{ $feature['item_key'] ?? 'feature-'.($f + 1) }}">

            <div class="ca-admin-repeater-row__controls">
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="up" {{ $f === 0 ? 'disabled' : '' }} aria-label="Naikkan urutan fitur ini">
                    <span data-lucide="arrow-up" aria-hidden="true"></span>
                </button>
                <button type="button" class="ca-admin-repeater-row__move" data-repeater-move="down" {{ $f === $featureLimit - 1 ? 'disabled' : '' }} aria-label="Turunkan urutan fitur ini">
                    <span data-lucide="arrow-down" aria-hidden="true"></span>
                </button>
            </div>

            <x-admin::form.field :name="'content.features.'.$f.'.title'" label="Judul Fitur">
                <x-admin::form.input :name="'content[features]['.$f.'][title]'" :error-key="'content.features.'.$f.'.title'" :value="$feature['title'] ?? ''" maxlength="140" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.features.'.$f.'.description'" label="Deskripsi Fitur">
                <x-admin::form.textarea :name="'content[features]['.$f.'][description]'" :error-key="'content.features.'.$f.'.description'" :value="$feature['description'] ?? ''" maxlength="700" rows="2" />
            </x-admin::form.field>

            <x-admin::media-picker
                :name="'content[features]['.$f.'][media_id]'"
                label="Gambar Fitur"
                :selected-media="$mediaById->get($feature['media_id'] ?? null)"
                :media-items="$recentMedia"
            />

            <x-admin::form.field :name="'content.features.'.$f.'.media_alt'" label="Alt Text Gambar">
                <x-admin::form.input :name="'content[features]['.$f.'][media_alt]'" :error-key="'content.features.'.$f.'.media_alt'" :value="$feature['media_alt'] ?? ''" maxlength="255" />
            </x-admin::form.field>

            <x-admin::form.checkbox
                :name="'content[features]['.$f.'][is_active]'"
                :error-key="'content.features.'.$f.'.is_active'"
                value="1"
                :checked="(bool) ($feature['is_active'] ?? false)"
                label="Tampilkan fitur ini"
            />
        </div>
    @endfor
</fieldset>
