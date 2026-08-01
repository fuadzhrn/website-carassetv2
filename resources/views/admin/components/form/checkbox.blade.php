@props([
    'name',
    'id' => null,
    'value' => '1',
    'checked' => false,
    'label' => null,
    'helper' => null,
])

@php
    $id = $id ?? $name;
    $errorMessage = $errors->first($name);
    $isChecked = old($name, null) !== null ? (bool) old($name) : (bool) $checked;
@endphp

<div class="ca-admin-checkbox">
    <input
        type="checkbox"
        name="{{ $name }}"
        id="{{ $id }}"
        value="{{ $value }}"
        @checked($isChecked)
        @if ($errorMessage) aria-invalid="true" @endif
        @if ($helper) aria-describedby="{{ $name }}-helper" @endif
        {{ $attributes->merge(['class' => 'ca-admin-checkbox__input']) }}
    >
    <label for="{{ $id }}" class="ca-admin-checkbox__label">{{ $label }}</label>
</div>

@if ($helper)
    <p id="{{ $name }}-helper" class="ca-admin-field__helper">{{ $helper }}</p>
@endif

@if ($errorMessage)
    <p id="{{ $name }}-error" class="ca-admin-field__error" role="alert">{{ $errorMessage }}</p>
@endif
