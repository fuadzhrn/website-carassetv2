@props([
    'name',
    'id' => null,
    'rows' => 4,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'maxlength' => null,
    'disabled' => false,
    'readonly' => false,
    'helper' => null,
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
@endphp

<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    rows="{{ $rows }}"
    @if ($placeholder) placeholder="{{ $placeholder }}" @endif
    @required($required)
    @disabled($disabled)
    @readonly($readonly)
    @if ($maxlength) maxlength="{{ $maxlength }}" @endif
    @if ($errorMessage) aria-invalid="true" @endif
    @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
    {{ $attributes->merge(['class' => 'ca-admin-field__control ca-admin-field__control--textarea']) }}
>{{ old($errorKey, $value) }}</textarea>
