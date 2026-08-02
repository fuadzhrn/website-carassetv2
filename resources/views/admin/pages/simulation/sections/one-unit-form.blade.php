<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi">
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="900" rows="3" />
</x-admin::form.field>

<x-admin::cms.data-status
    name-prefix="content"
    error-key-prefix="content"
    :value="$content['data_status'] ?? 'draft'"
    :status-note="$content['status_note'] ?? ''"
/>

<p class="ca-admin-field__helper">
    Seluruh nilai diisi secara manual. Sistem tidak menghitung selisih atau hasil akhir.
</p>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Breakdown Satu Unit</legend>

    <x-admin::cms.numeric-field
        name-prefix="content[gross_operational_result]"
        error-key-prefix="content.gross_operational_result"
        :values="$content['gross_operational_result'] ?? []"
        field-label="Hasil Operasional Bruto"
        format="rupiah"
        :label-max="120"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[operating_cost]"
        error-key-prefix="content.operating_cost"
        :values="$content['operating_cost'] ?? []"
        field-label="Biaya Operasional"
        format="rupiah"
        :label-max="120"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[vehicle_obligation]"
        error-key-prefix="content.vehicle_obligation"
        :values="$content['vehicle_obligation'] ?? []"
        field-label="Kewajiban Kendaraan"
        format="rupiah"
        :label-max="120"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[management_component]"
        error-key-prefix="content.management_component"
        :values="$content['management_component'] ?? []"
        field-label="Komponen Pengelolaan"
        format="rupiah"
        :label-max="120"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[projected_partner_result]"
        error-key-prefix="content.projected_partner_result"
        :values="$content['projected_partner_result'] ?? []"
        field-label="Proyeksi Hasil Operasional Mitra"
        format="rupiah"
        :label-max="120"
    />
</fieldset>

<x-admin::form.field name="content.summary_note" label="Summary Note">
    <x-admin::form.textarea name="content[summary_note]" error-key="content.summary_note" :value="$content['summary_note'] ?? ''" maxlength="500" rows="2" />
</x-admin::form.field>

<x-admin::cms.cta-fields
    :cta-data="$content['cta'] ?? []"
    field-name="content[cta]"
    error-key="content.cta"
    heading="CTA"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>
