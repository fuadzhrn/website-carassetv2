<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Isi" helper="Gunakan baris baru kosong untuk memisahkan paragraf, sesuai tampilan publik.">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="1500" rows="6" />
</x-admin::form.field>

<p class="ca-admin-legal-notice">
    <span data-lucide="alert-triangle" aria-hidden="true"></span>
    Isi disclaimer hanya berdasarkan informasi resmi yang telah disetujui. Sistem tidak membuat atau memvalidasi ketentuan hukum.
</p>

<fieldset class="ca-admin-repeater-group" data-repeater-group>
    <legend class="ca-admin-cta-fields__legend">Poin Ringkas (maks. 6 item, urutan dapat diubah)</legend>

    @for ($i = 0; $i < 6; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[['key' => 'text', 'label' => 'Poin '.($i + 1), 'maxlength' => 500]]"
            :values="$content['points'][$i] ?? []"
            :name-prefix="'content[points]['.$i.']'"
            :error-key-prefix="'content.points.'.$i"
            :active-checked="(bool) ($content['points'][$i]['is_active'] ?? false)"
            :item-key="$content['points'][$i]['item_key'] ?? 'point-'.($i + 1)"
            :show-reorder="true"
            :row-index="$i"
            :row-count="6"
        />
    @endfor
</fieldset>

<x-admin::form.field name="content.cta_title" label="Judul CTA Penutup">
    <x-admin::form.input name="content[cta_title]" error-key="content.cta_title" :value="$content['cta_title'] ?? ''" maxlength="180" />
</x-admin::form.field>

<x-admin::form.field name="content.cta_description" label="Deskripsi CTA Penutup">
    <x-admin::form.textarea name="content[cta_description]" error-key="content.cta_description" :value="$content['cta_description'] ?? ''" maxlength="500" rows="2" />
</x-admin::form.field>

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
    <x-admin::form.textarea name="content[microcopy]" error-key="content.microcopy" :value="$content['microcopy'] ?? ''" maxlength="500" rows="2" />
</x-admin::form.field>
