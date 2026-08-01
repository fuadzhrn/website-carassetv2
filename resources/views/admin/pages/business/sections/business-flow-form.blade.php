<x-admin::cms.section-header :content="$content" :description-max="700" />

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Tahap Alur Bisnis (5 slot tetap, urutan terkunci)</legend>

    @php
        $flowStageLabels = ['01 — Konsultasi', '02 — Verifikasi', '03 — Pengadaan', '04 — Operasional', '05 — Monitoring & Laporan'];
    @endphp

    @for ($i = 0; $i < 5; $i++)
        <x-admin::cms.fixed-list-row
            :fields="[
                ['key' => 'title', 'label' => 'Judul Tahap ('.$flowStageLabels[$i].')', 'maxlength' => 100],
                ['key' => 'description', 'label' => 'Deskripsi Tahap', 'type' => 'textarea', 'maxlength' => 350, 'rows' => 2],
            ]"
            :values="$content['stages'][$i] ?? []"
            :name-prefix="'content[stages]['.$i.']'"
            :error-key-prefix="'content.stages.'.$i"
            :active-checked="(bool) ($content['stages'][$i]['is_active'] ?? false)"
        />
    @endfor
</fieldset>

<x-admin::form.field name="content.closing_statement" label="Closing Statement">
    <x-admin::form.textarea name="content[closing_statement]" error-key="content.closing_statement" :value="$content['closing_statement'] ?? ''" maxlength="400" rows="3" />
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
