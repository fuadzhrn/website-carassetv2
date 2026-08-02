<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required helper="Gunakan baris baru untuk memisahkan dua baris judul, sesuai tampilan publik.">
    <x-admin::form.textarea name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="200" rows="2" />
</x-admin::form.field>

<x-admin::form.field name="content.narrative" label="Narasi" required>
    <x-admin::form.textarea name="content[narrative]" error-key="content.narrative" :value="$content['narrative'] ?? ''" maxlength="900" rows="4" />
</x-admin::form.field>

<x-admin::media-picker
    name="content[image_media_id]"
    label="Gambar"
    :selected-media="$mediaById->get($content['image_media_id'] ?? null)"
    :media-items="$recentMedia"
    helper="Kosongkan untuk memakai gambar bawaan section ini."
/>

<x-admin::form.field name="content.image_alt" label="Alt Text Gambar">
    <x-admin::form.input name="content[image_alt]" error-key="content.image_alt" :value="$content['image_alt'] ?? ''" maxlength="255" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Tahapan Perjalanan Driver (5 tahap, urutan dapat diubah)</legend>

    @for ($i = 0; $i < 5; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[
                ['key' => 'label', 'label' => 'Label Tahap '.($i + 1), 'maxlength' => 30],
                ['key' => 'title', 'label' => 'Judul Tahap', 'maxlength' => 100],
                ['key' => 'description', 'label' => 'Deskripsi Tahap', 'type' => 'textarea', 'maxlength' => 350, 'rows' => 2],
            ]"
            :values="$content['timeline'][$i] ?? []"
            :name-prefix="'content[timeline]['.$i.']'"
            :error-key-prefix="'content.timeline.'.$i"
            :active-checked="(bool) ($content['timeline'][$i]['is_active'] ?? false)"
            :item-key="$content['timeline'][$i]['item_key'] ?? 'timeline-'.($i + 1)"
            :show-reorder="true"
            :row-index="$i"
            :row-count="5"
        />
    @endfor
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Panel Setelah Unit Dimiliki</legend>

    <x-admin::form.field name="content.after_unit_panel.title" label="Judul Panel">
        <x-admin::form.input name="content[after_unit_panel][title]" error-key="content.after_unit_panel.title" :value="$content['after_unit_panel']['title'] ?? ''" maxlength="100" />
    </x-admin::form.field>

    <x-admin::form.field name="content.after_unit_panel.description" label="Pengantar Panel">
        <x-admin::form.input name="content[after_unit_panel][description]" error-key="content.after_unit_panel.description" :value="$content['after_unit_panel']['description'] ?? ''" maxlength="200" />
    </x-admin::form.field>

    <div data-repeater-group>
        @for ($i = 0; $i < 3; $i++)
            <x-admin::cms.fixed-list-row
                :fields="[['key' => 'text', 'label' => 'Item '.($i + 1), 'maxlength' => 180]]"
                :values="$content['after_unit_panel']['items'][$i] ?? []"
                :name-prefix="'content[after_unit_panel][items]['.$i.']'"
                :error-key-prefix="'content.after_unit_panel.items.'.$i"
                :active-checked="(bool) ($content['after_unit_panel']['items'][$i]['is_active'] ?? false)"
                :item-key="$content['after_unit_panel']['items'][$i]['item_key'] ?? 'after-unit-'.($i + 1)"
                :show-reorder="true"
                :row-index="$i"
                :row-count="3"
            />
        @endfor
    </div>

    <x-admin::form.checkbox
        name="content[after_unit_panel][is_active]"
        error-key="content.after_unit_panel.is_active"
        value="1"
        :checked="(bool) ($content['after_unit_panel']['is_active'] ?? true)"
        label="Tampilkan panel ini"
    />
</fieldset>

<x-admin::cms.cta-fields
    :cta-data="$content['cta'] ?? []"
    field-name="content[cta]"
    error-key="content.cta"
    heading="CTA"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>

<x-admin::form.field name="content.note" label="Catatan / Disclaimer">
    <x-admin::form.textarea name="content[note]" error-key="content.note" :value="$content['note'] ?? ''" maxlength="400" rows="2" />
</x-admin::form.field>
