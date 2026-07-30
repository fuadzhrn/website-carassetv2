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
    // errorId selalu dibuat (bukan hanya saat $error terisi) supaya
    // validasi front-end (JS) punya elemen tetap untuk diisi/ditampilkan,
    // dan aria-describedby tidak perlu diubah lagi lewat JS saat runtime.
    $errorId = $fieldId . '-error';
    $describedBy = trim(($helpId ?? '') . ' ' . $errorId);
@endphp

@if ($type === 'checkbox')
    <div class="ca-field ca-field--checkbox">
        <label class="ca-field__checkbox-label" for="{{ $fieldId }}">
            <input
                type="checkbox"
                id="{{ $fieldId }}"
                name="{{ $name }}"
                value="1"
                @if ($required) required aria-required="true" @endif
                aria-describedby="{{ $describedBy }}"
                {{ $attributes->merge(['class' => 'ca-field__checkbox-input']) }}
            >
            <span class="ca-field__checkbox-text ca-form-text">
                {{ $label }}
                @if ($required)
                    <span class="ca-visually-hidden">(wajib disetujui)</span>
                @endif
            </span>
        </label>

        @if ($help)
            <p id="{{ $helpId }}" class="ca-field__help">{{ $help }}</p>
        @endif

        <p id="{{ $errorId }}" class="ca-field__error" role="alert" @if (!$error) hidden @endif>{{ $error }}</p>
    </div>
@else
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
                aria-describedby="{{ $describedBy }}"
                {{ $attributes->merge(['class' => 'ca-field__control']) }}
            >{{ $value }}</textarea>
        @elseif ($type === 'select')
            <select
                id="{{ $fieldId }}"
                name="{{ $name }}"
                @if ($required) required aria-required="true" @endif
                aria-describedby="{{ $describedBy }}"
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
                aria-describedby="{{ $describedBy }}"
                {{ $attributes->merge(['class' => 'ca-field__control']) }}
            >
        @endif

        @if ($help)
            <p id="{{ $helpId }}" class="ca-field__help">{{ $help }}</p>
        @endif

        <p id="{{ $errorId }}" class="ca-field__error" role="alert" @if (!$error) hidden @endif>{{ $error }}</p>
    </div>
@endif
