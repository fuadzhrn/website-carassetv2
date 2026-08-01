<x-admin::cms.section-header :content="$content" :description-max="900" />

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

@php $panel = $content['monitoring_panel'] ?? []; @endphp

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Ilustrasi Monitoring</legend>

    <p class="ca-admin-field__helper">
        Panel ini hanya mengatur label ilustrasi. Tidak ada data kendaraan atau monitoring real-time yang diproses.
    </p>

    <x-admin::form.field name="content.monitoring_panel.illustration_label" label="Label Ilustrasi" required>
        <x-admin::form.input name="content[monitoring_panel][illustration_label]" error-key="content.monitoring_panel.illustration_label" :value="$panel['illustration_label'] ?? ''" maxlength="100" required />
    </x-admin::form.field>

    <x-admin::form.field name="content.monitoring_panel.panel_title" label="Judul Panel">
        <x-admin::form.input name="content[monitoring_panel][panel_title]" error-key="content.monitoring_panel.panel_title" :value="$panel['panel_title'] ?? ''" maxlength="120" />
    </x-admin::form.field>

    @php
        $monitoringBlocks = [
            'unit_status' => 'Status Unit',
            'driver_profile' => 'Profil Driver',
            'vehicle_activity' => 'Aktivitas Kendaraan',
            'maintenance_schedule' => 'Jadwal Perawatan',
            'operational_report' => 'Laporan Operasional',
        ];
    @endphp

    @foreach ($monitoringBlocks as $blockKey => $blockLabel)
        @php $block = $panel[$blockKey] ?? []; @endphp
        <fieldset class="ca-admin-repeater-group ca-admin-repeater-group--nested">
            <legend class="ca-admin-cta-fields__legend">{{ $blockLabel }}</legend>

            <x-admin::form.field name="content.monitoring_panel.{{ $blockKey }}.label" label="Label">
                <x-admin::form.input name="content[monitoring_panel][{{ $blockKey }}][label]" error-key="content.monitoring_panel.{{ $blockKey }}.label" :value="$block['label'] ?? ''" maxlength="80" />
            </x-admin::form.field>

            <x-admin::form.field name="content.monitoring_panel.{{ $blockKey }}.value" label="Value">
                <x-admin::form.input name="content[monitoring_panel][{{ $blockKey }}][value]" error-key="content.monitoring_panel.{{ $blockKey }}.value" :value="$block['value'] ?? ''" maxlength="120" />
            </x-admin::form.field>

            <x-admin::form.field name="content.monitoring_panel.{{ $blockKey }}.helper" label="Status Pill (opsional)" helper="Teks pill kecil di sebelah nilai, mis. 'Dalam Operasional'.">
                <x-admin::form.input name="content[monitoring_panel][{{ $blockKey }}][helper]" error-key="content.monitoring_panel.{{ $blockKey }}.helper" :value="$block['helper'] ?? ''" maxlength="250" />
            </x-admin::form.field>

            <x-admin::form.checkbox
                name="content[monitoring_panel][{{ $blockKey }}][is_active]"
                error-key="content.monitoring_panel.{{ $blockKey }}.is_active"
                value="1"
                :checked="(bool) ($block['is_active'] ?? true)"
                label="Tampilkan blok ini"
            />
        </fieldset>
    @endforeach
</fieldset>
