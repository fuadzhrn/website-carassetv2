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
])

@php
    $id = $id ?? $name;
    $errorMessage = $errors->first($name);
    $describedBy = collect([
        $helper ? $name.'-helper' : null,
        $errorMessage ? $name.'-error' : null,
    ])->filter()->implode(' ') ?: null;
    $resolvedValue = $type === 'password' ? null : old($name, $value);
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
