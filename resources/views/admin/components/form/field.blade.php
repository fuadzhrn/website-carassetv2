@props([
    'name',
    'label' => null,
    'required' => false,
    'helper' => null,
])

@php
    $errorMessage = $errors->first($name);
@endphp

<div class="ca-admin-field">
    @if ($label)
        <label for="{{ $name }}" class="ca-admin-field__label">
            {{ $label }}
            @if ($required)
                <span aria-hidden="true">*</span>
                <span class="ca-admin-visually-hidden">(wajib diisi)</span>
            @endif
        </label>
    @endif

    {{ $slot }}

    @if ($helper && ! $errorMessage)
        <p id="{{ $name }}-helper" class="ca-admin-field__helper">{{ $helper }}</p>
    @endif

    @if ($errorMessage)
        <p id="{{ $name }}-error" class="ca-admin-field__error" role="alert">{{ $errorMessage }}</p>
    @endif
</div>
