@props([
    'label',
    'name',
    'type' => 'text',
    'id' => null,
    'placeholder' => null,
    'required' => false,
])

@php
    $fieldId = $id ?? $name;
@endphp

<div class="ca-form-field">
    <label for="{{ $fieldId }}" class="ca-form-field__label ca-form-text">{{ $label }}</label>

    @if ($type === 'textarea')
        <textarea
            id="{{ $fieldId }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            {{ $attributes->merge(['class' => 'ca-form-field__input ca-form-text']) }}
        ></textarea>
    @else
        <input
            type="{{ $type }}"
            id="{{ $fieldId }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required @endif
            {{ $attributes->merge(['class' => 'ca-form-field__input ca-form-text']) }}
        >
    @endif
</div>
