{{--
    One {label, value, helper} numeric triple used across Simulasi's
    assumptions/one-unit/multiple-units sections. Renders a raw number
    input (never a formatted string) plus a live client-side preview
    (admin-simulation-editor.js) that only reflects the typed value back
    as Rp/hari/persen — the preview never computes anything and is never
    the source of truth (validation server-side is).

    $format: 'rupiah'|'days'|'percentage'|null — null renders the value
    input disabled with a "belum ditentukan" notice instead, reserved for
    a future field whose type audit cannot yet be determined.
--}}
{{--
    NOTE: $format's @props default is intentionally null, NOT 'rupiah'.
    Blade's @props macro resolves defaults via `$var ?? $default`, so a
    caller explicitly passing `:format="null"` would otherwise be silently
    overwritten back to a non-null default — null and "not passed" must
    stay indistinguishable from each other, never from a real format.
    Every other caller passes an explicit non-null format string, so this
    changes nothing for them.
--}}
@props([
    'namePrefix',
    'errorKeyPrefix',
    'values' => [],
    'fieldLabel',
    'format' => null,
    'labelMax' => 100,
    'helperMax' => 300,
])

<div class="ca-admin-numeric-field" data-numeric-field data-numeric-format="{{ $format }}">
    <p class="ca-admin-numeric-field__title">{{ $fieldLabel }}</p>

    <x-admin::form.field :name="$errorKeyPrefix.'.label'" label="Label Tampilan">
        <x-admin::form.input
            :name="$namePrefix.'[label]'"
            :error-key="$errorKeyPrefix.'.label'"
            :value="$values['label'] ?? ''"
            :maxlength="$labelMax"
        />
    </x-admin::form.field>

    @if ($format === null)
        <div class="ca-admin-field">
            <label class="ca-admin-field__label">Nilai</label>
            <input type="text" class="ca-admin-field__control" value="Jenis nilai belum ditentukan" disabled>
            <p class="ca-admin-field__helper">Jenis nilai (persentase atau Rupiah) belum ditentukan secara resmi — field ini terkunci sampai audit resmi menentukan jenisnya.</p>
        </div>
    @else
        <x-admin::form.field :name="$errorKeyPrefix.'.value'" label="Nilai ({{ $format === 'rupiah' ? 'Rupiah' : ($format === 'days' ? 'Hari' : 'Persen') }})">
            <input
                type="number"
                inputmode="numeric"
                min="0"
                step="{{ $format === 'percentage' ? '0.01' : '1' }}"
                name="{{ $namePrefix }}[value]"
                id="{{ $errorKeyPrefix }}.value"
                value="{{ old($errorKeyPrefix.'.value', $values['value'] ?? '') }}"
                class="ca-admin-field__control"
                data-numeric-input
            >
        </x-admin::form.field>

        <p class="ca-admin-numeric-field__preview" data-numeric-preview>
            Pratinjau Format Data: <span data-numeric-preview-value>—</span>
        </p>
    @endif

    <x-admin::form.field :name="$errorKeyPrefix.'.helper'" label="Helper / Keterangan">
        <x-admin::form.textarea
            :name="$namePrefix.'[helper]'"
            :error-key="$errorKeyPrefix.'.helper'"
            :value="$values['helper'] ?? ''"
            :maxlength="$helperMax"
            rows="2"
        />
    </x-admin::form.field>
</div>
