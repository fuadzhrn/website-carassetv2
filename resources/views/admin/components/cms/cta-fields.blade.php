{{--
    Reusable CTA field group for CMS section editors (Business and later
    pages). Home's own editor keeps its separate partial
    (admin/pages/home/partials/cta-fields.blade.php) untouched — this is a
    parallel component, not a replacement, so Home's field names/behavior
    are not touched by this or future pages adopting it.
--}}
@props([
    'ctaData' => [],
    'fieldName',
    'errorKey',
    'heading',
    'allowedRoutes',
    'allowedAnchors',
])

@php
    $currentRoute = $ctaData['route_name'] ?? '';
@endphp

<fieldset class="ca-admin-cta-fields" data-cta-fields data-allowed-anchors="{{ json_encode($allowedAnchors) }}">
    <legend class="ca-admin-cta-fields__legend">{{ $heading }}</legend>

    <x-admin::form.field :name="$errorKey.'.label'" label="Label CTA">
        <x-admin::form.input
            :name="$fieldName.'[label]'"
            :error-key="$errorKey.'.label'"
            :value="$ctaData['label'] ?? ''"
            maxlength="60"
        />
    </x-admin::form.field>

    <x-admin::form.field :name="$errorKey.'.destination_type'" label="Tujuan CTA">
        <x-admin::form.select
            :name="$fieldName.'[destination_type]'"
            :error-key="$errorKey.'.destination_type'"
            :options="['internal' => 'Halaman Internal', 'external' => 'URL Eksternal', 'none' => 'Tidak Ditampilkan']"
            :selected="$ctaData['destination_type'] ?? 'internal'"
            data-cta-destination-type
        />
    </x-admin::form.field>

    <div data-cta-group="internal">
        <x-admin::form.field :name="$errorKey.'.route_name'" label="Halaman Tujuan">
            <x-admin::form.select
                :name="$fieldName.'[route_name]'"
                :error-key="$errorKey.'.route_name'"
                :options="array_combine($allowedRoutes, $allowedRoutes)"
                :selected="$currentRoute"
                placeholder="Pilih halaman"
                data-cta-route-name
            />
        </x-admin::form.field>

        <x-admin::form.field :name="$errorKey.'.anchor'" label="Menuju Bagian (opsional)">
            <x-admin::form.select
                :name="$fieldName.'[anchor]'"
                :error-key="$errorKey.'.anchor'"
                :options="collect($allowedAnchors[$currentRoute] ?? [])->mapWithKeys(fn ($a) => [$a => $a])->all()"
                :selected="$ctaData['anchor'] ?? ''"
                placeholder="Tidak ada"
                data-cta-anchor
            />
        </x-admin::form.field>
    </div>

    <div data-cta-group="external">
        <x-admin::form.field :name="$errorKey.'.external_url'" label="URL Eksternal">
            <x-admin::form.input
                :name="$fieldName.'[external_url]'"
                :error-key="$errorKey.'.external_url'"
                type="url"
                :value="$ctaData['external_url'] ?? ''"
                placeholder="https://..."
            />
        </x-admin::form.field>

        <x-admin::form.checkbox
            :name="$fieldName.'[open_new_tab]'"
            :error-key="$errorKey.'.open_new_tab'"
            value="1"
            :checked="(bool) ($ctaData['open_new_tab'] ?? false)"
            label="Buka di tab baru"
        />
    </div>

    <x-admin::form.checkbox
        :name="$fieldName.'[is_active]'"
        :error-key="$errorKey.'.is_active'"
        value="1"
        :checked="(bool) ($ctaData['is_active'] ?? true)"
        label="Tampilkan CTA ini"
    />
</fieldset>
