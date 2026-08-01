@props([
    'name',
    'id' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'autocomplete' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'helper' => null,
    // Key dot-notation untuk old()/$errors saat $name memakai sintaks
    // array HTML (mis. settings[brand][name]) yang tidak dikenali old()/
    // $errors secara langsung. Default ke $name untuk field biasa.
    'errorKey' => null,
])

@php
    $errorKey = $errorKey ?? $name;
    $id = $id ?? $errorKey;
    $errorMessage = $errors->first($errorKey);
    $describedBy = collect([
        $helper ? $errorKey.'-helper' : null,
        $errorMessage ? $errorKey.'-error' : null,
    ])->filter()->implode(' ') ?: null;
    $resolvedValue = $type === 'password' ? null : old($errorKey, $value);
@endphp

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    @if ($resolvedValue !== null) value="{{ $resolvedValue }}" @endif
    @if ($placeholder) placeholder="{{ $placeholder }}" @endif
    @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
    @required($required)
    @disabled($disabled)
    @readonly($readonly)
    @if ($errorMessage) aria-invalid="true" @endif
    @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
    {{ $attributes->merge(['class' => 'ca-admin-field__control']) }}
>
