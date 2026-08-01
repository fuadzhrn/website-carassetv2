<x-admin::cms.section-header :content="$content" :description-max="700" />

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Label Diagram (4 zona tetap)</legend>

    @php $diagram = $content['diagram'] ?? []; @endphp

    <x-admin::form.field name="content.diagram.step_1_label" label="Zona 1 — Kepemilikan">
        <x-admin::form.input name="content[diagram][step_1_label]" error-key="content.diagram.step_1_label" :value="$diagram['step_1_label'] ?? ''" maxlength="80" />
    </x-admin::form.field>
    <x-admin::form.field name="content.diagram.step_2_label" label="Zona 2 — Operasional">
        <x-admin::form.input name="content[diagram][step_2_label]" error-key="content.diagram.step_2_label" :value="$diagram['step_2_label'] ?? ''" maxlength="80" />
    </x-admin::form.field>
    <x-admin::form.field name="content.diagram.step_3_label" label="Zona 3 — Hasil Operasional">
        <x-admin::form.input name="content[diagram][step_3_label]" error-key="content.diagram.step_3_label" :value="$diagram['step_3_label'] ?? ''" maxlength="80" />
    </x-admin::form.field>
    <x-admin::form.field name="content.diagram.step_4_label" label="Zona 4 — Pengembangan Aset">
        <x-admin::form.input name="content[diagram][step_4_label]" error-key="content.diagram.step_4_label" :value="$diagram['step_4_label'] ?? ''" maxlength="80" />
    </x-admin::form.field>
</fieldset>

<x-admin::media-picker
    name="content[image_media_id]"
    label="Gambar Hero"
    :selected-media="$mediaById->get($content['image_media_id'] ?? null)"
    :media-items="$recentMedia"
    helper="Kosongkan untuk memakai gambar bawaan section ini. Gambar ini dekoratif (teks utama sudah ada di overlay)."
/>

<x-admin::form.field name="content.image_alt" label="Alt Text Gambar">
    <x-admin::form.input name="content[image_alt]" error-key="content.image_alt" :value="$content['image_alt'] ?? ''" maxlength="255" />
</x-admin::form.field>

<x-admin::cms.cta-fields
    :cta-data="$content['cta'] ?? []"
    field-name="content[cta]"
    error-key="content.cta"
    heading="CTA"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>
