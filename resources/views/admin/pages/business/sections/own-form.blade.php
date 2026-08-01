<x-admin::cms.section-header :content="$content" :title-max="160" :description-max="900" />

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

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Poin Utama (maks. 4 slot)</legend>

    @for ($i = 0; $i < 4; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[['key' => 'text', 'label' => 'Slot '.($i + 1), 'maxlength' => 180]]"
            :values="$content['key_points'][$i] ?? []"
            :name-prefix="'content[key_points]['.$i.']'"
            :error-key-prefix="'content.key_points.'.$i"
            :active-checked="(bool) ($content['key_points'][$i]['is_active'] ?? false)"
        />
    @endfor
</fieldset>
