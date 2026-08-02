@php
    $unitMeta = [
        'one_unit' => ['title' => '1 Unit', 'count' => 1],
        'five_units' => ['title' => '5 Unit', 'count' => 5],
        'ten_units' => ['title' => '10 Unit', 'count' => 10],
    ];

    $metricLabels = [
        'gross_operational_result' => 'Hasil Operasional Bruto',
        'operating_cost' => 'Biaya Operasional',
        'vehicle_obligation' => 'Kewajiban Kendaraan',
        'management_component' => 'Komponen Pengelolaan',
        'projected_partner_result' => 'Proyeksi Hasil Mitra',
    ];
@endphp

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
    Nilai 5 dan 10 unit harus dimasukkan secara manual berdasarkan data resmi. Sistem tidak mengalikan nilai 1 unit.
</p>

@foreach ($unitMeta as $unitKey => $meta)
    @php $unit = $content['units'][$unitKey] ?? []; @endphp

    <fieldset class="ca-admin-package-group">
        <legend class="ca-admin-cta-fields__legend">Panel {{ $meta['title'] }}</legend>

        <div class="ca-admin-field">
            <label class="ca-admin-field__label">Jumlah Unit</label>
            <input type="text" class="ca-admin-field__control" value="{{ $meta['count'] }} Unit" disabled>
        </div>

        <x-admin::form.field :name="'content.units.'.$unitKey.'.label'" label="Label Panel">
            <x-admin::form.input :name="'content[units]['.$unitKey.'][label]'" :error-key="'content.units.'.$unitKey.'.label'" :value="$unit['label'] ?? ''" maxlength="80" />
        </x-admin::form.field>

        <x-admin::form.field :name="'content.units.'.$unitKey.'.description'" label="Deskripsi Panel">
            <x-admin::form.textarea :name="'content[units]['.$unitKey.'][description]'" :error-key="'content.units.'.$unitKey.'.description'" :value="$unit['description'] ?? ''" maxlength="400" rows="2" />
        </x-admin::form.field>

        @foreach ($metricLabels as $metricKey => $metricLabel)
            @php
                $isPercentageMetric = in_array($metricKey, ['management_component', 'projected_partner_result'], true);
                $metricFormat = $isPercentageMetric ? 'percentage' : 'rupiah';
            @endphp
            <div class="ca-admin-numeric-field" data-numeric-field data-numeric-format="{{ $metricFormat }}">
                <p class="ca-admin-numeric-field__title">{{ $metricLabel }}</p>

                <x-admin::form.field :name="'content.units.'.$unitKey.'.'.$metricKey" :label="'Nilai ('.($isPercentageMetric ? 'Persen' : 'Rupiah').')'">
                    <input
                        type="number"
                        inputmode="numeric"
                        min="0"
                        step="{{ $isPercentageMetric ? '0.01' : '1' }}"
                        name="content[units][{{ $unitKey }}][{{ $metricKey }}]"
                        id="content.units.{{ $unitKey }}.{{ $metricKey }}"
                        value="{{ old('content.units.'.$unitKey.'.'.$metricKey, $unit[$metricKey] ?? '') }}"
                        class="ca-admin-field__control"
                        data-numeric-input
                    >
                </x-admin::form.field>

                <p class="ca-admin-numeric-field__preview" data-numeric-preview>
                    Pratinjau Format Data: <span data-numeric-preview-value>&mdash;</span>
                </p>
            </div>
        @endforeach

        <x-admin::form.field :name="'content.units.'.$unitKey.'.note'" label="Catatan Panel">
            <x-admin::form.textarea :name="'content[units]['.$unitKey.'][note]'" :error-key="'content.units.'.$unitKey.'.note'" :value="$unit['note'] ?? ''" maxlength="400" rows="2" />
        </x-admin::form.field>

        <x-admin::form.checkbox
            :name="'content[units]['.$unitKey.'][is_active]'"
            :error-key="'content.units.'.$unitKey.'.is_active'"
            value="1"
            :checked="(bool) ($unit['is_active'] ?? true)"
            label="Tampilkan panel ini"
        />
    </fieldset>
@endforeach

<x-admin::form.field name="content.comparison_note" label="Comparison Note">
    <x-admin::form.textarea name="content[comparison_note]" error-key="content.comparison_note" :value="$content['comparison_note'] ?? ''" maxlength="600" rows="3" />
</x-admin::form.field>

<x-admin::cms.cta-fields
    :cta-data="$content['cta'] ?? []"
    field-name="content[cta]"
    error-key="content.cta"
    heading="CTA"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>
