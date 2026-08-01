{{--
    One row of a fixed-slot repeater (key points, stages, benefits, ...).
    Renders whatever text fields the caller declares, then a single
    "tampilkan slot ini" checkbox — used across Business's key_points,
    growth stages, and business-flow stages so each section form doesn't
    hand-roll the same row markup.

    $fields: list of ['key' => 'text', 'label' => 'Slot', 'type' => 'input'|'textarea', 'maxlength' => 180]
    $values: current row's data, keyed the same as $fields[]['key']
--}}
@props([
    'fields' => [],
    'values' => [],
    'namePrefix',
    'errorKeyPrefix',
    'activeChecked' => true,
    'activeLabel' => 'Tampilkan slot ini',
])

<div class="ca-admin-repeater-row">
    @foreach ($fields as $field)
        <x-admin::form.field
            :name="$errorKeyPrefix.'.'.$field['key']"
            :label="$field['label']"
        >
            @if (($field['type'] ?? 'input') === 'textarea')
                <x-admin::form.textarea
                    :name="$namePrefix.'['.$field['key'].']'"
                    :error-key="$errorKeyPrefix.'.'.$field['key']"
                    :value="$values[$field['key']] ?? ''"
                    :maxlength="$field['maxlength'] ?? 255"
                    :rows="$field['rows'] ?? 2"
                />
            @else
                <x-admin::form.input
                    :name="$namePrefix.'['.$field['key'].']'"
                    :error-key="$errorKeyPrefix.'.'.$field['key']"
                    :value="$values[$field['key']] ?? ''"
                    :maxlength="$field['maxlength'] ?? 180"
                />
            @endif
        </x-admin::form.field>
    @endforeach

    <x-admin::form.checkbox
        :name="$namePrefix.'[is_active]'"
        :error-key="$errorKeyPrefix.'.is_active'"
        value="1"
        :checked="(bool) $activeChecked"
        :label="$activeLabel"
    />
</div>
