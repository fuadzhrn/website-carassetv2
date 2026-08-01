{{--
    Reusable eyebrow/title/description group for CMS section editors.
    Every Business section (and most future ones) opens with this same
    trio, so it's extracted here rather than repeated 5×.
--}}
@props([
    'content' => [],
    'eyebrowMax' => 80,
    'titleMax' => 180,
    'descriptionMax' => 700,
    'descriptionRows' => 4,
    'showEyebrow' => true,
    'showDescription' => true,
])

@if ($showEyebrow)
    <x-admin::form.field name="content.eyebrow" label="Eyebrow">
        <x-admin::form.input name="content[eyebrow]" error-key="content.eyebrow" :value="$content['eyebrow'] ?? ''" :maxlength="$eyebrowMax" />
    </x-admin::form.field>
@endif

<x-admin::form.field name="content.title" label="Judul" required>
    <x-admin::form.input name="content[title]" error-key="content.title" :value="$content['title'] ?? ''" :maxlength="$titleMax" required />
</x-admin::form.field>

@if ($showDescription)
    <x-admin::form.field name="content.description" label="Deskripsi" required>
        <x-admin::form.textarea name="content[description]" error-key="content.description" :value="$content['description'] ?? ''" :maxlength="$descriptionMax" :rows="$descriptionRows" />
    </x-admin::form.field>
@endif
