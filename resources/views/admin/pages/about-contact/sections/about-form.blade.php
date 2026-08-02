<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.tagline" label="Tagline" helper="Kosongkan untuk memakai tagline brand global (Pengaturan Website).">
    <x-admin::form.input name="content[tagline]" error-key="content.tagline" :value="$content['tagline'] ?? ''" maxlength="180" />
</x-admin::form.field>

<x-admin::form.field name="content.narrative" label="Narasi" required helper="Gunakan baris baru kosong untuk memisahkan paragraf, sesuai tampilan publik.">
    <x-admin::form.textarea name="content[narrative]" error-key="content.narrative" :value="$content['narrative'] ?? ''" maxlength="1500" rows="5" />
</x-admin::form.field>

<x-admin::form.field name="content.positioning_statement" label="Positioning Statement" helper="Gunakan baris baru untuk memisahkan dua baris kutipan, sesuai tampilan publik.">
    <x-admin::form.textarea name="content[positioning_statement]" error-key="content.positioning_statement" :value="$content['positioning_statement'] ?? ''" maxlength="500" rows="2" />
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
