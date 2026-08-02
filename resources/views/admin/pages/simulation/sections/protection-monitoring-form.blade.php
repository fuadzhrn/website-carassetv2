@php
    $featureLabels = [
        'insurance' => 'Asuransi',
        'warranty' => 'Garansi',
        'gps' => 'GPS',
        'monitoring' => 'Monitoring',
        'maintenance' => 'Perawatan',
        'reporting' => 'Laporan',
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

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Fitur Tetap (6 fitur, tidak dapat ditambah/dihapus)</legend>

    @foreach ($featureLabels as $featureKey => $featureLabel)
        @php $feature = $content['features'][$featureKey] ?? []; @endphp

        <div class="ca-admin-repeater-row">
            <x-admin::form.field :name="'content.features.'.$featureKey.'.title'" :label="$featureLabel.' — Judul'">
                <x-admin::form.input :name="'content[features]['.$featureKey.'][title]'" :error-key="'content.features.'.$featureKey.'.title'" :value="$feature['title'] ?? ''" maxlength="120" />
            </x-admin::form.field>

            <x-admin::form.field :name="'content.features.'.$featureKey.'.description'" :label="$featureLabel.' — Deskripsi'">
                <x-admin::form.textarea :name="'content[features]['.$featureKey.'][description]'" :error-key="'content.features.'.$featureKey.'.description'" :value="$feature['description'] ?? ''" maxlength="500" rows="2" />
            </x-admin::form.field>

            <x-admin::form.checkbox
                :name="'content[features]['.$featureKey.'][is_active]'"
                :error-key="'content.features.'.$featureKey.'.is_active'"
                value="1"
                :checked="(bool) ($feature['is_active'] ?? true)"
                label="Tampilkan fitur ini"
            />
        </div>
    @endforeach
</fieldset>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Callout (opsional)</legend>

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
        :checked="(bool) ($content['callout']['is_active'] ?? false)"
        label="Tampilkan callout ini"
    />

    <p class="ca-admin-field__helper">
        Desain halaman saat ini tidak memiliki kotak callout — isi bagian ini hanya akan tampil di publik bila diaktifkan.
    </p>
</fieldset>

<x-admin::cms.cta-fields
    :cta-data="$content['cta'] ?? []"
    field-name="content[cta]"
    error-key="content.cta"
    heading="CTA (opsional)"
    :allowed-routes="$allowedRoutes"
    :allowed-anchors="$allowedAnchors"
/>
<p class="ca-admin-field__helper">
    Desain halaman saat ini tidak memiliki tombol CTA — CTA hanya akan tampil di publik bila diaktifkan.
</p>
