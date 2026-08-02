{{--
    Reusable draft/confirmed status field — used for Simulasi's numeric
    sections (PROMPT 20), and Tentang & Kontak's vision/mission editorial
    status + legal data status (PROMPT 21). This is NOT the CMS-wide Draft
    & Publish system — it only tracks whether one specific piece of
    content has been officially confirmed. Server-side "confirmed" gates
    (completeness checks) live in each page's own Form Request, not here.
--}}
@props([
    'namePrefix',
    'errorKeyPrefix',
    'statusFieldKey' => 'data_status',
    'value' => 'draft',
    'legend' => 'Status Data',
    'draftLabel' => 'Menunggu Konfirmasi',
    'confirmedLabel' => 'Telah Dikonfirmasi',
    'showStatusNote' => true,
    'statusNote' => null,
])

@php
    $errorKey = $errorKeyPrefix.'.'.$statusFieldKey;
@endphp

<fieldset class="ca-admin-data-status" data-status-field>
    <legend class="ca-admin-cta-fields__legend">{{ $legend }}</legend>

    <div class="ca-admin-data-status__options">
        <label class="ca-admin-data-status__option">
            <input type="radio" name="{{ $namePrefix }}[{{ $statusFieldKey }}]" value="draft" @checked(old($errorKey, $value) === 'draft')>
            {{ $draftLabel }}
        </label>
        <label class="ca-admin-data-status__option">
            <input type="radio" name="{{ $namePrefix }}[{{ $statusFieldKey }}]" value="confirmed" @checked(old($errorKey, $value) === 'confirmed')>
            {{ $confirmedLabel }}
        </label>
    </div>

    @if ($errors->first($errorKey))
        <p class="ca-admin-field__error" role="alert">{{ $errors->first($errorKey) }}</p>
    @endif

    @if ($showStatusNote)
        <x-admin::form.field :name="$errorKeyPrefix.'.status_note'" label="Status Note (opsional)">
            <x-admin::form.textarea
                :name="$namePrefix.'[status_note]'"
                :error-key="$errorKeyPrefix.'.status_note'"
                :value="$statusNote ?? ''"
                maxlength="300"
                rows="2"
            />
        </x-admin::form.field>
    @endif
</fieldset>
