{{--
    One row of a fixed-slot repeater (key points, stages, benefits, ...).
    Renders whatever text fields the caller declares, then a single
    "tampilkan slot ini" checkbox — used across Business's key_points,
    growth stages, and business-flow stages so each section form doesn't
    hand-roll the same row markup.

    $fields: list of ['key' => 'text', 'label' => 'Slot', 'type' => 'input'|'textarea', 'maxlength' => 180]
    $values: current row's data, keyed the same as $fields[]['key']

    $showReorder: when true, renders move-up/move-down buttons. These swap
    field VALUES with the adjacent row in the DOM (admin-repeaters.js) —
    the underlying slots/names never move, so this stays within the fixed
    max-slot pattern rather than a dynamic add/remove/clone engine.
--}}
@props([
    'fields' => [],
    'values' => [],
    'namePrefix',
    'errorKeyPrefix',
    'activeChecked' => true,
    'activeLabel' => 'Tampilkan slot ini',
    'showReorder' => false,
    'rowIndex' => null,
    'rowCount' => null,
    'itemKey' => null,
])

<div class="ca-admin-repeater-row" data-repeater-row>
    @if ($itemKey !== null)
        <input type="hidden" name="{{ $namePrefix }}[item_key]" value="{{ $itemKey }}">
    @endif

    @if ($showReorder)
        <div class="ca-admin-repeater-row__controls">
            <button
                type="button"
                class="ca-admin-repeater-row__move"
                data-repeater-move="up"
                {{ $rowIndex === 0 ? 'disabled' : '' }}
                aria-label="Naikkan urutan item ini"
            >
                <span data-lucide="arrow-up" aria-hidden="true"></span>
            </button>
            <button
                type="button"
                class="ca-admin-repeater-row__move"
                data-repeater-move="down"
                {{ ($rowCount !== null && $rowIndex === $rowCount - 1) ? 'disabled' : '' }}
                aria-label="Turunkan urutan item ini"
            >
                <span data-lucide="arrow-down" aria-hidden="true"></span>
            </button>
        </div>
    @endif

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
