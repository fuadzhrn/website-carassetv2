<p class="ca-admin-field__helper">
    Layout Hero publik bersifat vertikal dan terpusat (judul di tengah, gambar besar di bawah CTA) — bukan layout teks-kiri/gambar-kanan.
</p>

<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.model_name" label="Nama Model">
    <x-admin::form.input name="content[model_name]" error-key="content.model_name" :value="$content['model_name'] ?? ''" maxlength="100" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.tagline" label="Tagline">
    <x-admin::form.input name="content[tagline]" error-key="content.tagline" :value="$content['tagline'] ?? ''" maxlength="180" />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="1000" rows="4" />
</x-admin::form.field>

<x-admin::media-picker
    name="content[hero_media_id]"
    label="Gambar Hero"
    :selected-media="$mediaById->get($content['hero_media_id'] ?? null)"
    :media-items="$recentMedia"
    helper="Kosongkan untuk memakai gambar placeholder sementara. Gunakan hanya aset resmi/disetujui klien — lihat PRODUCT-ASSET-SOURCES-BYD-ATTO-1.md."
/>

<x-admin::form.field name="content.hero_alt" label="Alt Text Gambar Hero">
    <x-admin::form.input name="content[hero_alt]" error-key="content.hero_alt" :value="$content['hero_alt'] ?? ''" maxlength="255" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Badge Hero (maks. 4, urutan dapat diubah)</legend>

    @for ($i = 0; $i < ($limits['hero_badges'] ?? 4); $i++)
        <x-admin::cms.fixed-list-row
            :fields="[
                ['key' => 'label', 'label' => 'Badge '.($i + 1), 'maxlength' => 80],
            ]"
            :values="$content['badges'][$i] ?? []"
            :name-prefix="'content[badges]['.$i.']'"
            :error-key-prefix="'content.badges.'.$i"
            :active-checked="(bool) ($content['badges'][$i]['is_active'] ?? false)"
            :item-key="$content['badges'][$i]['item_key'] ?? 'badge-'.($i + 1)"
            :show-reorder="true"
            :row-index="$i"
            :row-count="$limits['hero_badges'] ?? 4"
        />
    @endfor
</fieldset>

<x-admin::cms.cta-fields
    :cta-data="$content['primary_cta'] ?? []"
    field-name="content[primary_cta]"
    error-key="content.primary_cta"
    heading="CTA Utama"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>

<x-admin::cms.cta-fields
    :cta-data="$content['secondary_cta'] ?? []"
    field-name="content[secondary_cta]"
    error-key="content.secondary_cta"
    heading="CTA Sekunder"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>

<x-admin::form.field name="content.microcopy" label="Microcopy">
    <x-admin::form.textarea name="content[microcopy]" error-key="content.microcopy" :value="$content['microcopy'] ?? ''" maxlength="400" rows="2" />
</x-admin::form.field>
