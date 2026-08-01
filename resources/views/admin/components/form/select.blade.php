@props([
    'name',
    'id' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
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
    $current = old($errorKey, $selected);
@endphp

<select
    name="{{ $name }}"
    id="{{ $id }}"
    @required($required)
    @disabled($disabled)
    @if ($errorMessage) aria-invalid="true" @endif
    @if ($describedBy) aria-describedby="{{ $describedBy }}" @endif
    {{ $attributes->merge(['class' => 'ca-admin-field__control ca-admin-field__control--select']) }}
>
    @if ($placeholder)
        <option value="" @selected(! $current)>{{ $placeholder }}</option>
    @endif

    @foreach ($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" @selected((string) $current === (string) $optionValue)>{{ $optionLabel }}</option>
    @endforeach
</select>
