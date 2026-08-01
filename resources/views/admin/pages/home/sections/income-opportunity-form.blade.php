<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field
    name="content.narrative"
    label="Narasi"
    required
    helper="Dua paragraf tampilan saat ini — pisahkan paragraf dengan satu baris kosong."
>
    <x-admin::form.textarea name="content[narrative]" error-key="content.narrative" :value="$content['narrative'] ?? ''" maxlength="1200" rows="8" />
</x-admin::form.field>

<x-admin::form.field
    name="content.editorial_statement"
    label="Pernyataan Editorial"
    helper="Baris baru akan ditampilkan sebagai baris terpisah pada panel."
>
    <x-admin::form.textarea name="content[editorial_statement]" error-key="content.editorial_statement" :value="$content['editorial_statement'] ?? ''" maxlength="300" rows="3" />
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

@include('admin.pages.home.partials.cta-fields', [
    'ctaData' => $content['cta'] ?? [],
    'fieldName' => 'content[cta]',
    'errorKey' => 'content.cta',
    'heading' => 'CTA',
    'allowedRoutes' => $allowedRoutes,
    'allowedAnchors' => $allowedAnchors,
])
