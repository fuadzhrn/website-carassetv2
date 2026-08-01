<x-admin::form.field name="content.eyebrow" label="Eyebrow">
    <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" maxlength="80" />
</x-admin::form.field>

<x-admin::form.field name="content.title_line_1" label="Judul Baris Pertama" required>
    <x-admin::form.input name="content[title_line_1]" error-key="content.title_line_1" :value="$content['title_line_1'] ?? ''" maxlength="80" required />
</x-admin::form.field>

<x-admin::form.field name="content.title_line_2" label="Judul Baris Kedua" required helper="Ditampilkan dengan aksen warna — bagian dari judul utama.">
    <x-admin::form.input name="content[title_line_2]" error-key="content.title_line_2" :value="$content['title_line_2'] ?? ''" maxlength="80" required />
</x-admin::form.field>

<x-admin::form.field name="content.subtitle" label="Subjudul">
    <x-admin::form.input name="content[subtitle]" error-key="content.subtitle" :value="$content['subtitle'] ?? ''" maxlength="180" />
</x-admin::form.field>

<x-admin::form.field name="content.description" label="Deskripsi" required>
    <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" maxlength="600" rows="4" />
</x-admin::form.field>

<fieldset class="ca-admin-repeater-group">
    <legend class="ca-admin-cta-fields__legend">Status Bar (3 slot tetap)</legend>

    @for ($i = 0; $i < 3; $i++)
        @php $item = $content['status_items'][$i] ?? []; @endphp
        <div class="ca-admin-repeater-row">
            <x-admin::form.field name="content.status_items.{{ $i }}.label" label="Slot {{ $i + 1 }}">
                <x-admin::form.input name="content[status_items][{{ $i }}][label]" error-key="content.status_items.{{ $i }}.label" :value="$item['label'] ?? ''" maxlength="80" />
            </x-admin::form.field>
            <x-admin::form.checkbox
                name="content[status_items][{{ $i }}][is_active]"
                error-key="content.status_items.{{ $i }}.is_active"
                value="1"
                :checked="(bool) ($item['is_active'] ?? true)"
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
