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

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Asumsi Angka</legend>

    <x-admin::cms.numeric-field
        name-prefix="content[operational_days]"
        error-key-prefix="content.operational_days"
        :values="$content['operational_days'] ?? []"
        field-label="Hari Operasional"
        format="days"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[daily_result]"
        error-key-prefix="content.daily_result"
        :values="$content['daily_result'] ?? []"
        field-label="Setoran / Hasil Operasional Harian"
        format="rupiah"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[operating_cost]"
        error-key-prefix="content.operating_cost"
        :values="$content['operating_cost'] ?? []"
        field-label="Biaya Operasional"
        format="rupiah"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[vehicle_installment]"
        error-key-prefix="content.vehicle_installment"
        :values="$content['vehicle_installment'] ?? []"
        field-label="Cicilan Kendaraan"
        format="rupiah"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[management_component]"
        error-key-prefix="content.management_component"
        :values="$content['management_component'] ?? []"
        field-label="Komponen Pengelolaan"
        format="rupiah"
    />

    <x-admin::cms.numeric-field
        name-prefix="content[revenue_share]"
        error-key-prefix="content.revenue_share"
        :values="$content['revenue_share'] ?? []"
        field-label="Pembagian Hasil Operasional"
        :format="null"
    />
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Callout</legend>

    <x-admin::form.field name="content.callout.title" label="Judul Callout">
        <x-admin::form.input name="content[callout][title]" error-key="content.callout.title" :value="$content['callout']['title'] ?? ''" maxlength="140" />
    </x-admin::form.field>

    <x-admin::form.field name="content.callout.description" label="Deskripsi Callout">
        <x-admin::form.textarea name="content[callout][description]" error-key="content.callout.description" :value="$content['callout']['description'] ?? ''" maxlength="500" rows="2" />
    </x-admin::form.field>

    <x-admin::form.checkbox
        name="content[callout][is_active]"
        error-key="content.callout.is_active"
        value="1"
        :checked="(bool) ($content['callout']['is_active'] ?? true)"
        label="Tampilkan callout ini"
    />
</fieldset>
