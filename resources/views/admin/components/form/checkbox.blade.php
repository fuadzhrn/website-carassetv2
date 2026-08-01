@props([
    'name',
    'id' => null,
    'value' => '1',
    'checked' => false,
    'label' => null,
    'helper' => null,
    'errorKey' => null,
    // Nilai formulir HTML tidak mengirim apa pun untuk checkbox yang tidak
    // dicentang — hidden input di depan checkbox menjamin "0" tetap
    // terkirim, sehingga is_active selalu punya nilai eksplisit.
    'withHiddenFallback' => true,
])

@php
    $errorKey = $errorKey ?? $name;
    $id = $id ?? $errorKey;
    $errorMessage = $errors->first($errorKey);
    $isChecked = old($errorKey, null) !== null ? (bool) old($errorKey) : (bool) $checked;
@endphp

<div class="ca-admin-checkbox">
    @if ($withHiddenFallback)
        <input type="hidden" name="{{ $name }}" value="0">
    @endif
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        @checked($isChecked)
        @if ($errorMessage) aria-invalid="true" @endif
        @if ($helper) aria-describedby="{{ $errorKey }}-helper" @endif
        {{ $attributes->merge(['class' => 'ca-admin-checkbox__input']) }}
    >
    <label for="{{ $id }}" class="ca-admin-checkbox__label">{{ $label }}</label>
</div>

@if ($helper)
    <p id="{{ $errorKey }}-helper" class="ca-admin-field__helper">{{ $helper }}</p>
@endif

@if ($errorMessage)
    <p id="{{ $errorKey }}-error" class="ca-admin-field__error" role="alert">{{ $errorMessage }}</p>
@endif
