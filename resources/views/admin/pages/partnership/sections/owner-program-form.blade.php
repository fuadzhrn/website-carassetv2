<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
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

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Callout Berposisi Tetap (4 slot, posisi terkunci: kiri atas, kanan atas, kiri bawah, kanan bawah)</legend>

    @for ($i = 0; $i < 4; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[['key' => 'label', 'label' => 'Callout '.($i + 1), 'maxlength' => 60]]"
            :values="$content['callouts'][$i] ?? []"
            :name-prefix="'content[callouts]['.$i.']'"
            :error-key-prefix="'content.callouts.'.$i"
            :active-checked="(bool) ($content['callouts'][$i]['is_active'] ?? false)"
        />
    @endfor
</fieldset>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Peran Mitra (maks. 4 item, urutan dapat diubah)</legend>

    @for ($i = 0; $i < 4; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[['key' => 'text', 'label' => 'Item '.($i + 1), 'maxlength' => 180]]"
            :values="$content['partner_roles'][$i] ?? []"
            :name-prefix="'content[partner_roles]['.$i.']'"
            :error-key-prefix="'content.partner_roles.'.$i"
            :active-checked="(bool) ($content['partner_roles'][$i]['is_active'] ?? false)"
            :item-key="$content['partner_roles'][$i]['item_key'] ?? 'partner-role-'.($i + 1)"
            :show-reorder="true"
            :row-index="$i"
            :row-count="4"
        />
    @endfor
</fieldset>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Peran CarAsset (maks. 4 item, urutan dapat diubah)</legend>

    @for ($i = 0; $i < 4; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[['key' => 'text', 'label' => 'Item '.($i + 1), 'maxlength' => 180]]"
            :values="$content['carasset_roles'][$i] ?? []"
            :name-prefix="'content[carasset_roles]['.$i.']'"
            :error-key-prefix="'content.carasset_roles.'.$i"
            :active-checked="(bool) ($content['carasset_roles'][$i]['is_active'] ?? false)"
            :item-key="$content['carasset_roles'][$i]['item_key'] ?? 'carasset-role-'.($i + 1)"
            :show-reorder="true"
            :row-index="$i"
            :row-count="4"
        />
    @endfor
</fieldset>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Benefit (maks. 3 item, urutan dapat diubah)</legend>

    @for ($i = 0; $i < 3; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[['key' => 'text', 'label' => 'Item '.($i + 1), 'maxlength' => 180]]"
            :values="$content['benefits'][$i] ?? []"
            :name-prefix="'content[benefits]['.$i.']'"
            :error-key-prefix="'content.benefits.'.$i"
            :active-checked="(bool) ($content['benefits'][$i]['is_active'] ?? false)"
            :item-key="$content['benefits'][$i]['item_key'] ?? 'benefit-'.($i + 1)"
            :show-reorder="true"
            :row-index="$i"
            :row-count="3"
        />
    @endfor
</fieldset>

<x-admin::cms.cta-fields
    :cta-data="$content['cta'] ?? []"
    field-name="content[cta]"
    error-key="content.cta"
    heading="CTA"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>

<x-admin::form.field name="content.microcopy" label="Microcopy Penutup">
    <x-admin::form.textarea name="content[microcopy]" error-key="content.microcopy" :value="$content['microcopy'] ?? ''" maxlength="300" rows="2" />
</x-admin::form.field>
