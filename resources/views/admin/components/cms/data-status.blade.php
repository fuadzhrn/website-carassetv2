{{--
    Draft/confirmed status for one Simulasi numeric section. This is NOT
    the CMS-wide Draft & Publish system (that comes in a later prompt) —
    it only tracks whether THIS section's numbers have been officially
    confirmed. "confirmed" is blocked server-side (UpdateSimulationSectionRequest)
    until that section's main numeric fields are filled.
--}}
@props([
    'namePrefix',
    'errorKeyPrefix',
    'value' => 'draft',
    'statusNote' => null,
])

<fieldset class="ca-admin-data-status" data-status-field>
    <legend class="ca-admin-cta-fields__legend">Status Data</legend>

    <div class="ca-admin-data-status__options">
        <label class="ca-admin-data-status__option">
            <input type="radio" name="{{ $namePrefix }}[data_status]" value="draft" @checked(old($errorKeyPrefix.'.data_status', $value) === 'draft')>
            Menunggu Konfirmasi
        </label>
        <label class="ca-admin-data-status__option">
            <input type="radio" name="{{ $namePrefix }}[data_status]" value="confirmed" @checked(old($errorKeyPrefix.'.data_status', $value) === 'confirmed')>
            Telah Dikonfirmasi
        </label>
    </div>

    @if ($errors->first($errorKeyPrefix.'.data_status'))
        <p class="ca-admin-field__error" role="alert">{{ $errors->first($errorKeyPrefix.'.data_status') }}</p>
    @endif

    <x-admin::form.field :name="$errorKeyPrefix.'.status_note'" label="Status Note (opsional)">
        <x-admin::form.textarea
            :name="$namePrefix.'[status_note]'"
            :error-key="$errorKeyPrefix.'.status_note'"
            :value="$statusNote ?? ''"
            maxlength="300"
            rows="2"
        />
    </x-admin::form.field>
</fieldset>
