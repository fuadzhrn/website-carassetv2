<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi" required>
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="600" rows="3" />
</x-admin::form.field>

@php
    $stepLabels = ['own' => '01 — Miliki Asetnya (OWN)', 'operate' => '02 — Kami Kelola Operasionalnya (OPERATE)', 'grow' => '03 — Kembangkan Kepemilikannya (GROW)'];
@endphp

@foreach ($stepLabels as $stepKey => $stepLabel)
    @php $step = $content['steps'][$stepKey] ?? []; @endphp
    <fieldset class="ca-admin-repeater-group">
        <legend class="ca-admin-cta-fields__legend">{{ $stepLabel }}</legend>

        <x-admin::form.field name="content.steps.{{ $stepKey }}.title" label="Judul Tahap" required>
            <x-admin::form.input name="content[steps][{{ $stepKey }}][title]" error-key="content.steps.{{ $stepKey }}.title" :value="$step['title'] ?? ''" maxlength="50" required />
        </x-admin::form.field>

        <x-admin::form.field name="content.steps.{{ $stepKey }}.description" label="Deskripsi Tahap" required>
            <x-admin::form.textarea name="content[steps][{{ $stepKey }}][description]" error-key="content.steps.{{ $stepKey }}.description" :value="$step['description'] ?? ''" maxlength="350" rows="3" />
        </x-admin::form.field>

        <x-admin::form.checkbox
            name="content[steps][{{ $stepKey }}][is_active]"
            error-key="content.steps.{{ $stepKey }}.is_active"
            value="1"
            :checked="(bool) ($step['is_active'] ?? true)"
            label="Tampilkan tahap ini"
        />
    </fieldset>
@endforeach

@include('admin.pages.home.partials.cta-fields', [
    'ctaData' => $content['cta'] ?? [],
    'fieldName' => 'content[cta]',
    'errorKey' => 'content.cta',
    'heading' => 'CTA',
    'allowedRoutes' => $allowedRoutes,
    'allowedAnchors' => $allowedAnchors,
])
