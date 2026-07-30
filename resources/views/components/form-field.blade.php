@props([
    'label',
    'name',
    'id' => null,
    'type' => 'text',
    'placeholder' => null,
    'required' => false,
    'value' => null,
    'help' => null,
    'error' => null,
    'options' => null,
])

@php
    $fieldId = $id ?? $name;
    $helpId = $help ? $fieldId . '-help' : null;
    $errorId = $error ? $fieldId . '-error' : null;
    $describedBy = trim(($helpId ?? '') . ' ' . ($errorId ?? ''));
@endphp

<div class="ca-field">
    <label for="{{ $fieldId }}" class="ca-field__label ca-label">
        {{ $label }}
        @if ($required)
            <span class="ca-field__required" aria-hidden="true">*</span>
            <span class="ca-visually-hidden">(wajib diisi)</span>
        @endif
    </label>

    @if ($type === 'textarea')
        <textarea
            id="{{ $fieldId }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required aria-required="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->merge(['class' => 'ca-field__control']) }}
        >{{ $value }}</textarea>
    @elseif ($type === 'select')
        <select
            id="{{ $fieldId }}"
            name="{{ $name }}"
            @if ($required) required aria-required="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->merge(['class' => 'ca-field__control']) }}
        >
            @foreach (($options ?? []) as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected($value === $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
    @else
        <input
            type="{{ $type }}"
            id="{{ $fieldId }}"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            @if ($required) required aria-required="true" @endif
            @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
            {{ $attributes->merge(['class' => 'ca-field__control']) }}
        >
    @endif

    @if ($help)
        <p id="{{ $helpId }}" class="ca-field__help">{{ $help }}</p>
    @endif

    @if ($error)
        <p id="{{ $errorId }}" class="ca-field__error" role="alert">{{ $error }}</p>
    @endif
</div>
