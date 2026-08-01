<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" maxlength="180" required />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi" required>
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="600" rows="3" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Trust Points (maks. 4 slot)</legend>

    @for ($i = 0; $i < 4; $i++)
        @php $point = $content['trust_points'][$i] ?? []; @endphp
        <div class="ca-admin-repeater-row">
            <x-admin::form.field name="content.trust_points.{{ $i }}.text" label="Slot {{ $i + 1 }}">
                <x-admin::form.input name="content[trust_points][{{ $i }}][text]" error-key="content.trust_points.{{ $i }}.text" :value="$point['text'] ?? ''" maxlength="180" />
            </x-admin::form.field>
            <x-admin::form.checkbox
                name="content[trust_points][{{ $i }}][is_active]"
                error-key="content.trust_points.{{ $i }}.is_active"
                value="1"
                :checked="(bool) ($point['is_active'] ?? true)"
                label="Tampilkan slot ini"
            />
        </div>
    @endfor
</fieldset>

@include('admin.pages.home.partials.cta-fields', [
    'ctaData' => $content['primary_cta'] ?? [],
    'fieldName' => 'content[primary_cta]',
    'errorKey' => 'content.primary_cta',
    'heading' => 'CTA Utama',
    'allowedRoutes' => $allowedRoutes,
    'allowedAnchors' => $allowedAnchors,
])

@include('admin.pages.home.partials.cta-fields', [
    'ctaData' => $content['secondary_cta'] ?? [],
    'fieldName' => 'content[secondary_cta]',
    'errorKey' => 'content.secondary_cta',
    'heading' => 'CTA Sekunder',
    'allowedRoutes' => $allowedRoutes,
    'allowedAnchors' => $allowedAnchors,
])

<x-admin::form.field name="content.microcopy" label="Microcopy">
    <x-admin::form.textarea name="content[microcopy]" error-key="content.microcopy" :value="$content['microcopy'] ?? ''" maxlength="350" rows="3" />
</x-admin::form.field>
